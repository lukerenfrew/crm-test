<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function employee_is_employed_by_company()
    {
        $employee = factory(Employee::class)->create([
            'company_id' => $company = factory(Company::class)->create()
        ]);

        $this->assertEquals($company->fresh(), $employee->company);
    }

    /**
     * @test
     */
    public function can_be_created_with_company()
    {
        $company = factory(Company::class)->create();

        $employee = Employee::make([
            'firstname' => 'Test',
            'surname' => 'User',
            'email' => 'test@user.com',
            'phone' => '012111111',
        ])->employedBy($company);

        $employee->save();

        $this->assertEquals($company->fresh(), $employee->fresh()->company);
    }
}
