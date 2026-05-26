<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class PaymentGatewayTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    private function createEmployee()
    {
        $department = Department::create([
            'name' => 'Engineering',
            'description' => 'Software Dev',
            'is_active' => true,
        ]);

        return Employee::create([
            'user_id' => User::factory()->create()->id,
            'department_id' => $department->id,
            'employee_code' => 'EMP123',
            'designation' => 'Developer',
            'date_of_joining' => '2026-01-01',
            'status' => 'active',
            'bank_name' => 'Demo Bank',
            'account_number' => '123456789',
            'ifsc_code' => 'DEMO000123',
        ]);
    }

    public function test_admin_can_access_checkout_page()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee = $this->createEmployee();

        $transaction = PaymentTransaction::create([
            'employee_id' => $employee->id,
            'transaction_reference' => 'TXNTEST123',
            'amount' => 1000.00,
            'status' => 'initiated',
        ]);

        $response = $this->actingAs($user)->get(route('transactions.checkout', $transaction));

        $response->assertStatus(200);
        $response->assertSee('PayManager Secure Gateway');
        $response->assertSee('REF: TXNTEST123');
    }

    public function test_admin_can_simulate_successful_checkout()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee = $this->createEmployee();
        $payroll = PayrollRecord::create([
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic' => 5000,
            'hra' => 2000,
            'allowances' => 1000,
            'net_salary' => 7000,
            'status' => 'approved',
        ]);

        $transaction = PaymentTransaction::create([
            'employee_id' => $employee->id,
            'payroll_record_id' => $payroll->id,
            'transaction_reference' => 'TXNTEST123',
            'amount' => 7000.00,
            'status' => 'initiated',
        ]);

        $response = $this->actingAs($user)->post(route('transactions.process-checkout', $transaction), [
            'simulate_status' => 'success',
        ]);

        $response->assertRedirect(route('transactions.index'));
        $transaction->refresh();
        $this->assertEquals('success', $transaction->status);
        $this->assertNotNull($transaction->paid_at);

        $payroll->refresh();
        $this->assertEquals('paid', $payroll->status);
    }

    public function test_admin_can_simulate_failed_checkout()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee = $this->createEmployee();
        $payroll = PayrollRecord::create([
            'employee_id' => $employee->id,
            'month' => 5,
            'year' => 2026,
            'basic' => 5000,
            'hra' => 2000,
            'allowances' => 1000,
            'net_salary' => 7000,
            'status' => 'approved',
        ]);

        $transaction = PaymentTransaction::create([
            'employee_id' => $employee->id,
            'payroll_record_id' => $payroll->id,
            'transaction_reference' => 'TXNTEST123',
            'amount' => 7000.00,
            'status' => 'initiated',
        ]);

        $response = $this->actingAs($user)->post(route('transactions.process-checkout', $transaction), [
            'simulate_status' => 'failed',
            'failure_reason' => 'Insufficient funds',
        ]);

        $response->assertRedirect(route('transactions.index'));
        $transaction->refresh();
        $this->assertEquals('failed', $transaction->status);
        $this->assertEquals('Insufficient funds', $transaction->failure_reason);

        $payroll->refresh();
        $this->assertEquals('approved', $payroll->status);
    }

    public function test_index_filters_correctly_with_search_and_status()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee1 = $this->createEmployee();
        
        $employee2 = Employee::create([
            'user_id' => User::factory()->create()->id,
            'department_id' => $employee1->department_id,
            'employee_code' => 'EMP456',
            'designation' => 'Developer',
            'date_of_joining' => '2026-01-01',
            'status' => 'active',
            'bank_name' => 'Demo Bank',
            'account_number' => '987654321',
            'ifsc_code' => 'DEMO000123',
        ]);

        // Transaction 1: failed, reference has "TARGET"
        $transaction1 = PaymentTransaction::create([
            'employee_id' => $employee1->id,
            'transaction_reference' => 'TARGET123',
            'amount' => 1000.00,
            'status' => 'failed',
        ]);

        // Transaction 2: success, reference has "TARGET"
        $transaction2 = PaymentTransaction::create([
            'employee_id' => $employee2->id,
            'transaction_reference' => 'TARGET456',
            'amount' => 2000.00,
            'status' => 'success',
        ]);

        // If we search for status=failed and search=TARGET:
        // We should ONLY get transaction1. We should NOT get transaction2.
        $response = $this->actingAs($user)->get(route('transactions.index', [
            'status' => 'failed',
            'search' => 'TARGET',
        ]));

        $response->assertStatus(200);
        $transactions = $response->viewData('transactions');
        
        $this->assertCount(1, $transactions);
        $this->assertEquals('TARGET123', $transactions->first()->transaction_reference);
    }

    public function test_bulk_pay_remark_month_formatting_on_31st()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee = $this->createEmployee();
        
        // Approved payroll record for February (month = 2)
        $payroll = PayrollRecord::create([
            'employee_id' => $employee->id,
            'month' => 2,
            'year' => 2026,
            'basic' => 5000,
            'hra' => 2000,
            'allowances' => 1000,
            'net_salary' => 7000,
            'status' => 'approved',
        ]);

        // Freeze time to the 31st of a month, e.g. May 31, 2026
        $this->travelTo(Carbon::parse('2026-05-31'));

        $response = $this->actingAs($user)->post(route('transactions.bulk-pay'));

        $response->assertRedirect(route('transactions.index'));

        $transaction = PaymentTransaction::where('payroll_record_id', $payroll->id)->first();
        $this->assertNotNull($transaction);
        $this->assertStringContainsString('February', $transaction->remarks);
    }

    public function test_cannot_link_payroll_record_of_another_employee()
    {
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $employee1 = $this->createEmployee();
        
        $employee2 = Employee::create([
            'user_id' => User::factory()->create()->id,
            'department_id' => $employee1->department_id,
            'employee_code' => 'EMP456',
            'designation' => 'Developer',
            'date_of_joining' => '2026-01-01',
            'status' => 'active',
            'bank_name' => 'Demo Bank',
            'account_number' => '987654321',
            'ifsc_code' => 'DEMO000123',
        ]);

        // Payroll for employee 2
        $payroll = PayrollRecord::create([
            'employee_id' => $employee2->id,
            'month' => 5,
            'year' => 2026,
            'basic' => 5000,
            'hra' => 2000,
            'allowances' => 1000,
            'net_salary' => 7000,
            'status' => 'approved',
        ]);

        // Attempting to post transaction for Employee 1 with Employee 2's payroll ID
        $response = $this->actingAs($user)
            ->from(route('transactions.create'))
            ->post(route('transactions.store'), [
                'employee_id' => $employee1->id,
                'payroll_record_id' => $payroll->id,
                'amount' => 7000,
                'payment_method' => 'bank_transfer',
            ]);

        $response->assertRedirect(route('transactions.create'));
        $response->assertSessionHas('error', 'The selected payroll record does not belong to the selected employee.');
        
        $this->assertEquals(0, PaymentTransaction::count());
    }
}

