<?php

namespace Tests\Unit;

use App\Company;
use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function company_has_many_employees()
    {
        $company = factory(Company::class)->create();

        factory(Employee::class, 10)->create();

        $this->assertCount(10, $company->employees);
    }
}
