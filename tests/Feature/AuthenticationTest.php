<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_register()
    {
        $response = $this->post('/register', [
            'account_type' => 'student',
            'name' => 'Test User',
            'email' => 'test.user@uit.ac.ma',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function test_students_cannot_register_with_external_email()
    {
        $response = $this->post('/register', [
            'account_type' => 'student',
            'name' => 'Outsider',
            'email' => 'outsider@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_users_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'login.test@uit.ac.ma',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/');
    }

    public function test_students_cannot_login_with_external_email_domain()
    {
        $user = User::factory()->create([
            'email' => 'someone@gmail.com',
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
