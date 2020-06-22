<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_login_as_admin()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @test
     */
    public function cant_login_with_invalid_password()
    {
        factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this
            ->from('/login')
            ->post('/login', [
                'email' => 'admin@admin.com',
                'password' => 'invalid_password',
            ]);

        $response->assertRedirect('/login');
        $this->assertGuest();

        $response->assertSessionHasErrors('email');
        $this->assertEquals('admin@admin.com', session()->getOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
    }
}
