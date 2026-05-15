<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\SalaryStructure;
use App\Models\PayrollRecord;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['name' => 'Priya Sharma',  'email' => 'priya@company.com',  'dept' => 'Human Resources', 'designation' => 'HR Manager',         'basic' => 35000, 'hra' => 14000, 'allowances' => 8000],
            ['name' => 'Rahul Kumar',   'email' => 'rahul@company.com',  'dept' => 'Finance',          'designation' => 'Senior Accountant',  'basic' => 30000, 'hra' => 12000, 'allowances' => 6000],
            ['name' => 'Anjali Mehta',  'email' => 'anjali@company.com', 'dept' => 'Operations',       'designation' => 'Operations Lead',    'basic' => 28000, 'hra' => 11000, 'allowances' => 5000],
            ['name' => 'Vikram Singh',  'email' => 'vikram@company.com', 'dept' => 'Engineering',      'designation' => 'DevOps Engineer',    'basic' => 40000, 'hra' => 16000, 'allowances' => 9000],
            ['name' => 'Neha Gupta',    'email' => 'neha@company.com',   'dept' => 'Engineering',      'designation' => 'Frontend Developer', 'basic' => 32000, 'hra' => 12800, 'allowances' => 7000],
            ['name' => 'Arjun Patel',   'email' => 'arjun@company.com',  'dept' => 'Finance',          'designation' => 'Finance Analyst',    'basic' => 27000, 'hra' => 10800, 'allowances' => 5500],
            ['name' => 'Sunita Rao',    'email' => 'sunita@company.com', 'dept' => 'Human Resources',  'designation' => 'HR Executive',       'basic' => 22000, 'hra' => 8800,  'allowances' => 4500],
            ['name' => 'Deepak Verma',  'email' => 'deepak@company.com', 'dept' => 'Operations',       'designation' => 'Operations Manager', 'basic' => 38000, 'hra' => 15200, 'allowances' => 8500],
        ];

        $deptCache = [];

        foreach ($employees as $data) {

            if (!isset($deptCache[$data['dept']])) {
                $deptCache[$data['dept']] = Department::where('name', $data['dept'])->first();
            }
            $dept = $deptCache[$data['dept']];

            if (!$dept) {
                $this->command->warn('Department not found: ' . $data['dept']);
                continue;
            }

            if (User::where('email', $data['email'])->exists()) {
                $this->command->info('Skipping existing user: ' . $data['email']);
                continue;
            }

            $user = User::create([
                'name'              => $data['name'],
                'email'             => $data['email'],
                'password'          => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
            $user->assignRole('employee');

            $code = 'EMP' . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT);

            $employee = Employee::create([
                'user_id'         => $user->id,
                'department_id'   => $dept->id,
                'employee_code'   => $code,
                'designation'     => $data['designation'],
                'phone'           => '98765' . rand(10000, 99999),
                'date_of_joining' => now()->subMonths(rand(3, 24)),
                'status'          => 'active',
                'bank_name'       => 'State Bank of India',
                'account_number'  => '3' . rand(100000000, 999999999),
                'ifsc_code'       => 'SBIN000' . rand(1000, 9999),
            ]);

            SalaryStructure::create([
                'employee_id'    => $employee->id,
                'basic'          => $data['basic'],
                'hra'            => $data['hra'],
                'allowances'     => $data['allowances'],
                'pf_percentage'  => 12,
                'esi_percentage' => 1.75,
                'tds'            => rand(500, 2000),
                'effective_from' => now()->subMonths(6),
            ]);

            foreach ([2, 1] as $monthsAgo) {
                $date  = now()->subMonths($monthsAgo);
                $month = $date->month;
                $year  = $date->year;

                $gross           = $data['basic'] + $data['hra'] + $data['allowances'];
                $pf              = ($data['basic'] * 12) / 100;
                $esi             = ($gross * 1.75) / 100;
                $tds             = rand(500, 2000);
                $totalDeductions = $pf + $esi + $tds;
                $netSalary       = $gross - $totalDeductions;
                $status          = $monthsAgo == 2 ? 'paid' : 'approved';

                $payroll = PayrollRecord::create([
                    'employee_id'      => $employee->id,
                    'month'            => $month,
                    'year'             => $year,
                    'basic'            => $data['basic'],
                    'hra'              => $data['hra'],
                    'allowances'       => $data['allowances'],
                    'gross'            => $gross,
                    'pf'               => $pf,
                    'esi'              => $esi,
                    'tds'              => $tds,
                    'total_deductions' => $totalDeductions,
                    'net_salary'       => $netSalary,
                    'status'           => $status,
                ]);

                if ($status === 'paid') {
                    $statuses  = ['success', 'success', 'success', 'failed'];
                    $txnStatus = $statuses[array_rand($statuses)];
                    $monthName = Carbon::create()->month($month)->format('F');

                    PaymentTransaction::create([
                        'employee_id'           => $employee->id,
                        'payroll_record_id'      => $payroll->id,
                        'transaction_reference'  => 'TXN' . strtoupper(uniqid()),
                        'amount'                 => $netSalary,
                        'payment_method'         => 'bank_transfer',
                        'status'                 => $txnStatus,
                        'bank_name'              => 'State Bank of India',
                        'account_number'         => $employee->account_number,
                        'ifsc_code'              => $employee->ifsc_code,
                        'remarks'                => 'Salary for ' . $monthName . ' ' . $year,
                        'paid_at'                => $txnStatus === 'success' ? now()->subMonths($monthsAgo) : null,
                    ]);
                }
            }

            $this->command->info('Created: ' . $data['name']);
        }

        $this->command->info('Sample data seeded successfully!');
    }
}