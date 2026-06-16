<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_create_post()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'New Test Post',
            'content' => 'This is the content of the test post.',
        ]);

        $this->assertDatabaseHas('posts', ['title' => 'New Test Post']);
        $response->assertStatus(302); // Redirects to show page
    }

    public function test_user_can_only_edit_their_own_post()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $post = Post::create([
            'title' => 'Owner Post',
            'content' => 'Content',
            'user_id' => $owner->id
        ]);

        // Try to edit as someone else
        $response = $this->actingAs($otherUser)->put("/posts/{$post->id}", [
            'title' => 'Hacked Title',
            'content' => 'Hacked Content',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('posts', ['title' => 'Hacked Title']);
    }

    public function test_user_can_delete_their_own_post()
    {
        $user = User::factory()->create();
        $post = Post::create([
            'title' => 'Post to delete',
            'content' => 'Content',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->delete("/posts/{$post->id}");

        $response->assertRedirect('/posts');
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}