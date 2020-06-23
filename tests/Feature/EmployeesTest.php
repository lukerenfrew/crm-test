<?php

namespace Tests\Feature;

use App\Company;

use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_only_administer_employees_as_an_admin()
    {
        $this->visitRoute('employee.index')
            ->seeRouteIs('login');

        $this->visitRoute('employee.show', 1)
            ->seeRouteIs('login');

        $this->visitRoute('employee.create')
            ->seeRouteIs('login');

        $this->post(route('employee.store'))
            ->followRedirects()
            ->seeRouteIs('login');

        $this->visitRoute('employee.edit', 1)
            ->seeRouteIs('login');

        $this->put(route('employee.update', 1))
            ->followRedirects()
            ->seeRouteIs('login');

        $this->visitRoute('employee.destroy', 1)
            ->seeRouteIs('login');
    }

    /**
     * @test
     */
    public function can_view_all_employees()
    {
        $this->actingAsAdmin();

        $company = factory(Company::class)->create([
            'name' => 'Company #1'
        ]);

        factory(Employee::class)->create([
            'firstname' => 'Test',
            'surname' => 'User',
            'email' => 'test@email.com',
            'phone' => '01213111111',
            'company_id' => $company->id
        ]);

        factory(Employee::class)->create([
            'firstname' => 'Another',
            'surname' => 'User',
            'email' => 'another@email.com',
            'phone' => '01213999999',
            'company_id' => $company->id
        ]);

        $this->visitRoute('employee.index')
            ->seeText('Test User')
            ->seeText('test@email.com')
            ->seeText('01213111111')
            ->seeLink('Company #1', route('company.show', $company))
            ->seeText('Another User')
            ->seeText('another@email.com')
            ->seeText('01213999999');
    }

    /**
     * @test
     */
    public function employees_are_paginated()
    {
        $employees = factory(Employee::class, 11)->create();

        $this
            ->actingAsAdmin()
            ->visitRoute('employee.index')
            ->seeText($employees[9]->email)
            ->dontSeeText($employees[10]->email)
            ->within('.pagination', function () {
                $this->seeInElement('.page-link', 1);
                $this->seeLink('2', route('employee.index', ['page' => 2]));
            });
    }

    /**
     * @test
     */
    public function can_view_an_employee()
    {
        $company = factory(Company::class)->create([
            'name' => 'Company #1'
        ]);

        $employee = factory(Employee::class)->create([
            'firstname' => 'Test',
            'surname' => 'User',
            'email' => 'test@email.com',
            'phone' => '01213111111',
            'company_id' => $company->id
        ]);

        $this->actingAsAdmin()
            ->visitRoute('employee.show', $employee->id)
            ->seeText('Test User')
            ->seeText('test@email.com')
            ->seeText('01213111111')
            ->seeLink('Company #1', route('company.show', $employee));
    }

    /**
     * @test
     */
    public function can_create_an_employee()
    {
        $company = factory(Company::class)->create();
        $this
            ->actingAsAdmin()
            ->visitRoute('employee.create')
            ->submitForm('Create',
                [
                    'firstname' => 'Test',
                    'surname' => 'User',
                    'phone' => '01213111111',
                    'email' => 'Test@email.com',
                    'company' => $company->id
                ]
            )
            ->seeRouteIs('employee.index')
            ->seeText('Employee created');

        $this->seeInDatabase('employees', [
            'firstname' => 'Test',
            'surname' => 'User',
            'phone' => '01213111111',
            'email' => 'Test@email.com',
            'company_id' => $company->id
        ]);
    }

    /**
     * @test
     */
    public function employee_is_validated_on_creation()
    {
        $this
            ->actingAsAdmin()
            ->visitRoute('employee.create')
            ->submitForm('Create', [
                'firstname' => '',
                'surname' => '',
                'phone' => '',
                'email' => 'invalid'
            ])
            ->seeRouteIs('employee.create')
            ->seeText('The first name field is required')
            ->seeText('The last name field is required')
            ->seeText('The email must be a valid email address')
            ->seeText('The selected company is invalid')
            ->dontSeeText('Employee created')
            ->assertEmpty(Employee::get());
    }

    /**
     * @test
     */
    public function can_update_employee()
    {
        $company = factory(Company::class)->create([
            'name' => 'Company #1'
        ]);

        $company2 = factory(Company::class)->create([
            'name' => 'Company #2'
        ]);

        $employee = factory(Employee::class)->create([
            'firstname' => 'Test',
            'surname' => 'User',
            'email' => 'test@email.com',
            'phone' => '01213111111',
            'company_id' => $company->id
        ]);

        $this
            ->actingAsAdmin()
            ->visitRoute('employee.edit', $employee->id)
            ->seeInField('firstname', 'Test')
            ->seeInField('surname', 'User')
            ->seeInField('email', 'test@email.com')
            ->seeInField('phone', '01213111111')
            ->seeIsSelected('company', $company->id)
            ->submitForm('Update', [
                'firstname' => 'Test edit',
                'surname' => 'User edit',
                'email' => 'edit@email.com',
                'phone' => '012139999',
                'company' => $company2->id
            ])
            ->seeRouteIs('employee.index')
            ->seeText('Employee updated');

        $this->seeInDatabase('employees', [
            'firstname' => 'Test edit',
            'surname' => 'User edit',
            'email' => 'edit@email.com',
            'phone' => '012139999',
            'company_id' => $company2->id
        ]);
    }

    /**
     * @test
     */
    public function employee_is_validated_on_update()
    {
        $employee = factory(Employee::class)->create();

        $this
            ->actingAsAdmin()
            ->visitRoute('employee.edit', $employee->id)
            ->submitForm('Update', [
                'firstname' => '',
                'surname' => '',
                'email' => 'invalid',
                'phone' => '',
            ])
            ->seeRouteIs('employee.edit', $employee->id)
            ->seeText('The first name field is required')
            ->seeText('The last name field is required')
            ->seeText('The email must be a valid email address')
            ->dontSeeText('Employee updated');
    }

    /**
     * @test
     */
    public function can_delete_an_employee()
    {
        $employee = factory(Employee::class)->create();

        $this
            ->actingAsAdmin()
            ->delete(route('employee.destroy', $employee->id))
            ->followRedirects()
            ->seeRouteIs('employee.index')
            ->seeText('EMPLOYEE deleted');

        $this->dontSeeInDatabase('employees', [
            'id' => $employee->id
        ]);
    }
}
