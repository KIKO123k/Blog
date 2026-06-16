<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that comments can be displayed on a post details page.
     */
    public function test_comments_are_displayed_on_post_page(): void
    {
        $user = User::create([
            'name' => 'John Author',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $post = Post::create([
            'title' => 'My Great Post',
            'content' => 'Post content details...',
            'user_id' => $user->id,
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'author_name' => 'Alice Visitor',
            'content' => 'I love this post!',
        ]);

        $response = $this->get('/posts/' . $post->slug);

        $response->assertStatus(200);
        $response->assertSee('Alice Visitor');
        $response->assertSee('I love this post!');
    }

    /**
     * Test that a visitor can post a valid comment.
     */
    public function test_visitor_can_post_comment(): void
    {
        $user = User::create([
            'name' => 'John Author',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $post = Post::create([
            'title' => 'My Great Post',
            'content' => 'Post content details...',
            'user_id' => $user->id,
        ]);

        $response = $this->post('/posts/' . $post->slug . '/comments', [
            'author_name' => 'Bob Visitor',
            'content' => 'This is a test comment.',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'author_name' => 'Bob Visitor',
            'content' => 'This is a test comment.',
        ]);
    }

    /**
     * Test comment validation.
     */
    public function test_comment_validation(): void
    {
        $user = User::create([
            'name' => 'John Author',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $post = Post::create([
            'title' => 'My Great Post',
            'content' => 'Post content details...',
            'user_id' => $user->id,
        ]);

        $response = $this->post('/posts/' . $post->slug . '/comments', [
            'author_name' => '',
            'content' => '',
        ]);

        $response->assertSessionHasErrors(['author_name', 'content']);
        $this->assertDatabaseCount('comments', 0);
    }
}
