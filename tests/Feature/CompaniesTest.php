<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_only_administer_companies_as_an_admin()
    {
        $this->get(route('company.index'))
            ->assertRedirect(route('login'));

        $this->get(route('company.show', 1))
            ->assertRedirect(route('login'));

        $this->get(route('company.create'))
            ->assertRedirect(route('login'));

        $this->post(route('company.store'))
            ->assertRedirect(route('login'));

        $this->get(route('company.edit', 1))
            ->assertRedirect(route('login'));

        $this->put(route('company.update', 1))
            ->assertRedirect(route('login'));

        $this->get(route('company.destroy', 1))
            ->assertRedirect(route('login'));
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
            'logo' => 'LOGO?',
            'website' => 'http://www.company1.com',
        ]);

        factory(Company::class)->create([
            'name' => 'company #2',
            'email' => 'admin@company2.com',
            'logo' => 'LOGO?',
            'website' => 'http://www.company2.com',
        ]);

        $this->get(route('company.index'))
            ->assertViewHas(['companies']);
    }

    /**
     * @test
     */
    public function can_view_a_company()
    {
        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'LOGO?',
            'website' => 'http://www.company1.com',
        ]);

        $this->actingAsAdmin()
            ->get(route('company.show', $company->id))
            ->assertViewHas('company', $company);
    }

    /**
     * @test
     */
    public function can_create_a_company()
    {
        $this
            ->actingAsAdmin()
            ->post(route('company.store'), [
                'name' => 'company #1',
                'email' => 'admin@company1.com',
                'logo' => 'LOGO?',
                'website' => 'http://www.company1.com',
            ])
            ->assertRedirect(route('company.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('companies', [
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'LOGO?',
            'website' => 'http://www.company1.com',
        ]);
    }

    /**
     * @test
     */
    public function can_update_company()
    {
        $company = factory(Company::class)->create([
            'name' => 'company #1',
            'email' => 'admin@company1.com',
            'logo' => 'LOGO?',
            'website' => 'http://www.company1.com',
        ]);

        $this
            ->actingAsAdmin()
            ->put(route('company.update', $company->id), [
                'name' => 'updated company #1',
                'email' => 'other@company1.com',
                'logo' => 'updated_LOGO?',
                'website' => 'http://www.company1.co.uk',
            ])
            ->assertRedirect(route('company.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('companies', [
            'name' => 'updated company #1',
            'email' => 'other@company1.com',
            'logo' => 'updated_LOGO?',
            'website' => 'http://www.company1.co.uk',
        ]);
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
            ->assertRedirect(route('company.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('companies', [
            'id' => 'updated company #1',
            $company->id
        ]);
    }
}
