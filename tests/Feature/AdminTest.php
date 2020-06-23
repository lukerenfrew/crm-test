<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function cannot_access_admin_panel_unless_authenticated()
    {
        $this
            ->visitRoute('admin.dashboard')
            ->seeRouteIs('login');
    }

    /**
     * @test
     */
    public function can_access_admin_panel_when_authenticated()
    {
        $this->actingAsAdmin()
            ->visitRoute('admin.dashboard')
            ->assertResponseOk();
    }
}
