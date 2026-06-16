<?php

namespace App\Providers;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use App\Models\Major;
use App\Models\Category;
use App\Models\Club;
use App\Models\Comment;
use App\Models\MajorComment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class GateServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define Gates based on UserRole
        $this->defineGates();
    }

    /**
     * Define all gates.
     */
    protected function defineGates(): void
    {
        // Post gates
        Gate::define('post.create', function (User $user) {
            return $user->hasAnyRole([UserRole::AUTHOR, UserRole::ADMIN]);
        });

        Gate::define('post.update', function (User $user, Post $post) {
            return $user->id === $post->user_id || $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('post.delete', function (User $user, Post $post) {
            return $user->id === $post->user_id || $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('post.publish', function (User $user) {
            return $user->hasAnyRole([UserRole::AUTHOR, UserRole::ADMIN]);
        });

        // Major gates
        Gate::define('major.create', function (User $user) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('major.update', function (User $user, Major $major) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('major.delete', function (User $user, Major $major) {
            return $user->hasRole(UserRole::ADMIN);
        });

        // Category gates
        Gate::define('category.create', function (User $user) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('category.update', function (User $user, Category $category) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('category.delete', function (User $user, Category $category) {
            return $user->hasRole(UserRole::ADMIN);
        });

        // Club gates
        Gate::define('club.create', function (User $user) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('club.update', function (User $user, Club $club) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('club.delete', function (User $user, Club $club) {
            return $user->hasRole(UserRole::ADMIN);
        });

        // User management gates
        Gate::define('user.view', function (User $user) {
            return $user->hasRole(UserRole::USER);
        });

        Gate::define('user.update', function (User $user, User $target) {
            return $user->id === $target->id || $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('user.delete', function (User $user, User $target) {
            return $user->hasRole(UserRole::ADMIN) && $user->id !== $target->id;
        });

        Gate::define('user.assign-role', function (User $user) {
            return $user->hasRole(UserRole::ADMIN);
        });

        // Comment gates
        Gate::define('comment.delete-any', function (User $user) {
            return $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('comment.delete', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || $user->hasRole(UserRole::ADMIN);
        });

        Gate::define('major-comment.delete', function (User $user, MajorComment $comment) {
            return $user->id === $comment->user_id || $user->hasRole(UserRole::ADMIN);
        });
    }
}