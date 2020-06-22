<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;


    /**
     * @test
     */
    public function cant_register_as_a_new_user()
    {
        $this
            ->get('/register')
            ->assertStatus(404);

        $this
            ->post('/register')
            ->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_login_as_a_user()
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
    public function can_login_with_remember_token()
    {

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

    /**
     * @test
     */
    public function can_request_password_reset()
    {

    }

    /**
     * @test
     */
    public function can_reset_password()
    {

    }
}
