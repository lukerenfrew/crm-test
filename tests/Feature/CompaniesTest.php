<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
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
        $this->actingAs(factory(User::class)->create());
    }

    /**
     * @test
     */
    public function can_view_a_company()
    {

    }

    /**
     * @test
     */
    public function can_create_a_company()
    {

    }

    /**
     * @test
     */
    public function can_create_update_company()
    {

    }

    /**
     * @test
     */
    public function can_delete_a_company()
    {

    }
}
