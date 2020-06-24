<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
            ->seeStatusCode(Response::HTTP_NOT_FOUND);

        $this
            ->post('/register')
            ->seeStatusCode(Response::HTTP_NOT_FOUND);
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

        $this->visitRoute('login')
            ->submitForm('Sign In', [
                'email' => 'admin@admin.com',
                'password' => 'password',
            ])
            ->seeRouteIs('admin.dashboard')
            ->seeIsAuthenticatedAs($user);
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

        $this
            ->visitRoute('login')
            ->submitForm('Sign In', [
                'email' => 'admin@admin.com',
                'password' => 'invalid_password',
            ])
            ->seeRouteIs('login')
            ->dontSeeIsAuthenticated()
            ->seeText('These credentials do not match our records.')
            ->seeInField('email', 'admin@admin.com')
            ->seeInField('password', '');
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

        $this
            ->visitRoute('password.request')
            ->submitForm('Send Password Reset Link', [
                'email' => 'admin@admin.com',
            ])
            ->seeRouteIs('password.request')
            ->seeText('We have emailed your password reset link!');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * @test
     */
    public function email_is_required_for_password_reset()
    {
        $this
            ->visitRoute('password.request')
            ->submitForm('Send Password Reset Link', [
                'email' => '',
            ])
            ->seeRouteIs('password.request')
            ->seeText('The email field is required.');
    }

    /**
     * @test
     */
    public function can_reset_a_password()
    {

        $user = factory(User::class)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        Notification::fake();

        $this
            ->visitRoute('password.request')
            ->submitForm('Send Password Reset Link', [
                'email' => 'admin@admin.com',
            ])
            ->seeRouteIs('password.request')
            ->seeText('We have emailed your password reset link!');

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
            $token = $notification->token;
            return true;
        });

        $this
            ->visitRoute('password.reset', $token)
            ->submitForm('Reset Password', [
                'email' => 'admin@admin.com',
                'password' => 'new_password',
                'password_confirmation' => 'new_password',
                'token' => $token
            ])
            ->seeRouteIs('admin.dashboard');
    }
}
