<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompaniesTest extends TestCase
{
    use DatabaseMigrations;

    public function setup(): void
    {
        parent::setup();
        $this->actingAs(factory(User::class)->create());
    }

    public function can_only_administer_companies_as_an_admin()
    {
        $this->get(route('companies'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->get(route('company/1'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->post(route('company/create'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->get(route('company/1/edit'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->post(route('company/1/update'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);

        $this->get(route('company/1/delete'))
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function can_view_all_companies()
    {

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
