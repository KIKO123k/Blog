<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'role',
        'bio', 'linkedin_url', 'github_url', 'phone', 'phone_privacy',
        'cv_path', 'avatar_path', 'filiere', 'promotion',
        'account_type', 'company_name', 'badge_path', 'recruiter_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's role as a string.
     */
    public function getRoleAttribute(): string
    {
        return $this->attributes['role'] ?? 'user';
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->is_admin === true;
    }

    /**
     * Check if user is author or higher.
     */
    public function isAuthor(): bool
    {
        return in_array($this->role, ['author', 'admin']);
    }

    /**
     * Get the roles assigned to this user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->roles()->where('slug', $role->value)->exists();
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param UserRole[] $roles
     */
    public function hasAnyRole(array $roles): bool
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the user has all of the given roles.
     *
     * @param UserRole[] $roles
     */
    public function hasAllRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Assign a role to this user.
     */
    public function assignRole(UserRole $role): void
    {
        $roleModel = Role::findBySlug($role->value);
        if ($roleModel && !$this->hasRole($role)) {
            $this->roles()->attach($roleModel);
        }
    }

    /**
     * Remove a role from this user.
     */
    public function removeRole(UserRole $role): void
    {
        $roleModel = Role::findBySlug($role->value);
        if ($roleModel) {
            $this->roles()->detach($roleModel);
        }
    }

    /**
     * Sync roles for this user.
     *
     * @param UserRole[] $roles
     */
    public function syncRoles(array $roles): void
    {
        $roleModels = Role::whereIn('slug', array_map(fn($r) => $r->value, $roles))->get();
        $this->roles()->sync($roleModels);
    }

    /**
     * Ratings given by the user.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the posts written by the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class)->orderByDesc('year');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class)->orderByDesc('year');
    }

    /** Clubs dont l'utilisateur est membre. */
    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'club_user')
            ->withPivot('role', 'is_bureau')->withTimestamps();
    }

    /** Événements auxquels l'utilisateur est inscrit. */
    public function eventRegistrations()
    {
        return $this->belongsToMany(Event::class, 'event_user')->withTimestamps();
    }

    /** Annonces "recherche de coéquipiers". */
    public function teamPosts()
    {
        return $this->hasMany(TeamPost::class)->latest();
    }

    /** Objets perdus / trouvés signalés. */
    public function lostFoundItems()
    {
        return $this->hasMany(LostFoundItem::class)->latest();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'requester_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    public function friendshipWith(int $userId): ?Friendship
    {
        return Friendship::where(function ($q) use ($userId) {
            $q->where('requester_id', $this->id)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('requester_id', $userId)->where('receiver_id', $this->id);
        })->first();
    }

    public function isFriendWith(int $userId): bool
    {
        return Friendship::where('status', 'accepted')
            ->where(function ($q) use ($userId) {
                $q->where('requester_id', $this->id)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($userId) {
                $q->where('status', 'accepted')
                  ->where('requester_id', $userId)->where('receiver_id', $this->id);
            })->exists();
    }

    public function pendingRequestsCount(): int
    {
        return $this->receivedFriendRequests()->where('status', 'pending')->count();
    }

    /** Collection des amis acceptés (peu importe qui a initié). */
    public function friends()
    {
        $ids = Friendship::where('status', 'accepted')
            ->where(fn ($q) => $q->where('requester_id', $this->id)->orWhere('receiver_id', $this->id))
            ->get()
            ->map(fn ($f) => $f->requester_id === $this->id ? $f->receiver_id : $f->requester_id);

        return User::whereIn('id', $ids)->orderBy('name')->get();
    }

    /** Articles repostés sur le portfolio. */
    public function reposts()
    {
        return $this->belongsToMany(Post::class, 'reposts')->withTimestamps()->latest('reposts.created_at');
    }

    public function hasReposted(int $postId): bool
    {
        return $this->reposts()->where('posts.id', $postId)->exists();
    }

    /** Nombre de messages non lus reçus. */
    public function unreadMessagesCount(): int
    {
        return Message::where('receiver_id', $this->id)->whereNull('read_at')->count();
    }

    /** Notifications de l'application (cloche). */
    public function appNotifications()
    {
        return $this->hasMany(UserNotification::class)->latest();
    }

    public function unreadNotificationsCount(): int
    {
        return UserNotification::where('user_id', $this->id)->whereNull('read_at')->count();
    }

    /* ---- Account type & recruiter helpers ---- */

    public function isStudent(): bool
    {
        return $this->account_type === 'student';
    }

    public function isRecruiter(): bool
    {
        return $this->account_type === 'recruiter';
    }

    public function isVerifiedRecruiter(): bool
    {
        return $this->account_type === 'recruiter' && $this->recruiter_status === 'approved';
    }

    /**
     * Whether $viewer is allowed to see/download this user's CV.
     * Rule: the owner themself, or a verified recruiter.
     */
    public function cvVisibleTo(?User $viewer): bool
    {
        if (!$this->cv_path) {
            return false;
        }
        if ($viewer && $viewer->id === $this->id) {
            return true; // owner sees their own CV
        }
        return $viewer && $viewer->isVerifiedRecruiter();
    }
}
