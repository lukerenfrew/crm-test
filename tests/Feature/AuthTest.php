<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
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

        $response = $this->post(route('login'), [
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
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
            ->from(route('login'))
            ->post(route('login'), [
                'email' => 'admin@admin.com',
                'password' => 'invalid_password',
            ]);

        $response->assertRedirect(route('login'));
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
        $user = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        Notification::fake();

        $response = $this
            ->from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'admin@admin.com',
            ]);

        $response->assertRedirect(route('password.request'));

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * @test
     */
    public function can_reset_password()
    {
        factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $this->post(route('password.email'), [
            'email' => 'admin@admin.com',
        ]);

        $response = $this->post(route('password.update'), [
            'email' => 'admin@admin.com',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
            'token' => 'TOKEN'
        ]);

        $response->assertRedirect('/');
    }
}
