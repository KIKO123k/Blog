<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest users are redirected to login.
     */
    public function test_guest_cannot_access_profile_page(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated users can access the profile page.
     */
    public function test_authenticated_user_can_access_profile_page(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('jane@example.com');
        $response->assertSee('Jane Doe');
    }

    /**
     * Test successful profile update.
     */
    public function test_user_can_update_profile_info(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Jane Updated',
            'email' => 'jane.updated@example.com',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Updated',
            'email' => 'jane.updated@example.com',
        ]);
    }

    /**
     * Test password update.
     */
    public function test_user_can_update_password(): void
    {
        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('oldpassword'),
        ]);

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect();
        
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    /**
     * Test email uniqueness validation.
     */
    public function test_profile_update_validation_email_uniqueness(): void
    {
        $user1 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
        ]);

        $user2 = User::create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        // Attempting to change user1's email to user2's email should fail validation
        $response = $this->actingAs($user1)->put('/profile', [
            'name' => 'Jane Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors(['email']);
        
        // Changing user1's profile but keeping user1's email should pass
        $response2 = $this->actingAs($user1)->put('/profile', [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
        ]);

        $response2->assertSessionHasNoErrors();
    }
}
