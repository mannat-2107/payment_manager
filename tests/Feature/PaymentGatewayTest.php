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
}
