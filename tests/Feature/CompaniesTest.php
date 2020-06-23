<?php

namespace Tests\Feature;

use App\Company;

use App\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_only_administer_companies_as_an_admin()
    {
        $this->visitRoute('company.index')
            ->seeRouteIs('login');

        $this->visitRoute('company.show', 1)
            ->seeRouteIs('login');

        $this->visitRoute('company.create')
            ->seeRouteIs('login');

        $this->post(route('company.store'))
            ->followRedirects()
            ->seeRouteIs('login');

        $this->visitRoute('company.edit', 1)
            ->seeRouteIs('login');

        $this->put(route('company.update', 1))
            ->followRedirects()
            ->seeRouteIs('login');

        $this->visitRoute('company.destroy', 1)
            ->seeRouteIs('login');
    }

    /**
     * @test
     */
    public function can_view_all_companies()
    {
        $this->actingAsAdmin();

        factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'logo1.jpg',
            'website' => 'http://www.company1.com',
        ]);

        factory(Company::class)->create([
            'name' => 'company #2',
            'email' => 'admin@company2.com',
            'logo' => 'logo2.jpg',
            'website' => 'http://www.company2.com',
        ]);

        $this->visitRoute('company.index')
            ->see('company #1')
            ->see('admin@company1.com')
            ->seeElement('img', ['src' => 'http://crm-test.test/logos/logo1.jpg'])
            ->see('http://www.company1.com')
            ->see('company #2')
            ->see('admin@company2.com')
            ->seeElement('img', ['src' => 'http://crm-test.test/logos/logo2.jpg'])
            ->see('http://www.company2.com');
    }

    /**
     * @test
     */
    public function companies_are_paginated()
    {
        $companies = factory(Company::class, 11)->create();

        $this
            ->actingAsAdmin()
            ->visitRoute('company.index')
            ->seeText($companies[9]->name)
            ->dontSeeText($companies[10]->name)
            ->within('.pagination', function () {
                $this->seeInElement('.page-link', 1);
                $this->seeLink('2', route('company.index', ['page' => 2]));
            });
    }

    /**
     * @test
     */
    public function can_view_a_company()
    {
        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'logo1.jpg',
            'website' => 'http://www.company1.com',
        ]);

        $employee = factory(Employee::class)->create([
            'company_id' => $company->id,
            'firstname' => 'Test',
            'surname' => 'Employee',
        ]);

        $this->actingAsAdmin()
            ->visitRoute('company.show', $company->id)
            ->see('company #1')
            ->see('admin@company1.com')
            ->seeElement('img', ['src' => 'http://crm-test.test/logos/logo1.jpg'])
            ->see('http://www.company1.com')
            ->seeLink('Test Employee', route('employee.show', $employee));;
    }

    /**
     * @test
     */
    public function can_create_a_company()
    {
        Storage::fake('logos');

        $logoFile = UploadedFile::fake()->image('logo.jpg', 100, 100);

        $this
            ->actingAsAdmin()
            ->visitRoute('company.create')
            ->submitForm('Create',
                [
                    'name' => 'company #1',
                    'email' => 'admin@company1.com',
                    'website' => 'http://www.company1.com',
                    'logo' => $logoFile
                ]
            )
            ->seeRouteIs('company.index')
            ->seeText('Company created');

        $this->seeInDatabase('companies', [
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'website' => 'http://www.company1.com',
        ]);
    }

    /**
     * @test
     */
    public function can_upload_a_logo()
    {
        Storage::fake('logos');
        $logoFile = UploadedFile::fake()->image('logo.jpg', 100, 100);

        $this->actingAsAdmin()
            ->json('post', route('company.store'), [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'website' => 'http://www.company1.com',
                'logo' => $logoFile
            ])
            ->seeInDatabase('companies', [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'logo' => $logoFile->hashName(),
                'website' => 'http://www.company1.com',
            ]);

        Storage::disk('logos')->assertExists($logoFile->hashName());
    }

    /**
     * @test
     */
    public function company_is_validated_on_creation()
    {
        $this
            ->actingAsAdmin()
            ->visitRoute('company.create')
            ->submitForm('Create', [
                'name' => '',
                'email' => 'invalid',
                'logo' => UploadedFile::fake()->image('logo2.jpg', 10, 100),
                'website' => '',
            ])
            ->seeRouteIs('company.create')
            ->seeText('Name field is required')
            ->seeText('The logo has invalid image dimensions')
            ->seeText('The email must be a valid email address')
            ->dontSeeText('Company created')
            ->assertEmpty(Company::get());
    }

    /**
     * @test
     */
    public function can_update_company()
    {
        Storage::fake('logos');

        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'logo.jpg',
            'website' => 'http://www.company1.com',
        ]);

        $this
            ->actingAsAdmin()
            ->visitRoute('company.edit', $company->id)
            ->seeInField('name', 'company #1')
            ->seeInField('email', 'admin@company1.com')
            ->seeInField('website', 'http://www.company1.com')
            ->seeElement('img', ['src' => 'http://crm-test.test/logos/logo.jpg'])
            ->submitForm('Update', [
                'name' => 'updated company #1',
                'email' => 'other@company1.com',
                'logo' => '',
                'website' => 'http://www.company1.co.uk',
            ])
            ->seeRouteIs('company.index')
            ->seeText('Company updated');

        $this->seeInDatabase('companies', [
            'name' => 'updated company #1',
            'email' => 'other@company1.com',
            'website' => 'http://www.company1.co.uk',
        ]);
    }

    /**
     * @test
     */
    public function can_update_company_logo()
    {
        Storage::fake('logos');
        $logoFile = UploadedFile::fake()->image('logo2.jpg', 100, 100);

        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'logo.jpg',
            'website' => 'http://www.company1.com',
        ]);

        $this->actingAsAdmin()
            ->json('patch', route('company.update', $company->id), [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'website' => 'http://www.company1.com',
                'logo' => $logoFile
            ])
            ->seeInDatabase('companies', [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'logo' => $logoFile->hashName(),
                'website' => 'http://www.company1.com',
            ]);

        Storage::disk('logos')->assertExists($logoFile->hashName());
    }

    /**
     * @test
     */
    public function company_is_validated_on_update()
    {
        $company = factory(Company::class)->create();

        $this
            ->actingAsAdmin()
            ->visitRoute('company.edit', $company->id)
            ->submitForm('Update', [
                'name' => '',
                'email' => 'invalid',
                'logo' => UploadedFile::fake()->image('logo2.jpg', 10, 100),
                'website' => '',
            ])
            ->seeRouteIs('company.edit', $company->id)
            ->seeText('Name field is required')
            ->seeText('The logo has invalid image dimensions')
            ->seeText('The email must be a valid email address')
            ->dontSeeText('Company updated');
    }

    /**
     * @test
     */
    public function logo_is_only_validated_if_a_new_file_is_uploaded()
    {
        $company = factory(Company::class)->create();

        $logoFile = UploadedFile::fake()->image('logo2.jpg', 10, 10);

        $this
            ->actingAsAdmin()
            ->visitRoute('company.edit', $company->id)
            ->submitForm('Update', [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'website' => 'http://www.company1.com',
                'logo' => $logoFile
            ])
            ->seeRouteIs('company.edit', $company->id)
            ->seeText('The logo has invalid image dimensions')
            ->dontSeeText('Company updated');
    }

    /**
     * @test
     */
    public function can_delete_a_company()
    {
        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'LOGO?',
            'website' => 'http://www.company1.com',
        ]);

        $this
            ->actingAsAdmin()
            ->delete(route('company.destroy', $company->id))
            ->followRedirects()
            ->seeRouteIs('company.index')
            ->seeText('Company deleted');

        $this->dontSeeInDatabase('companies', [
            'id' => $company->id
        ]);
    }
}
