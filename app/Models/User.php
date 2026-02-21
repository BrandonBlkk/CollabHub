<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'phone',
        'location',
        'country',
        'country_code',
        'status',
        'balance'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'balance' => 'decimal:2',
    ];

    // Relationships
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function freelancer()
    {
        return $this->hasOne(Freelancer::class);
    }

    public function profileViews()
    {
        return $this->hasMany(ProfileView::class, 'profile_user_id');
    }

    public function jobViews()
    {
        return $this->hasMany(JobView::class, 'viewer_id');
    }

    public function viewedJobs()
    {
        return $this->belongsToMany(Job::class, 'job_views', 'viewer_id', 'job_id')
            ->withTimestamps();
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    public function friendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', 'pending')
            ->withTimestamps();
    }

    public function sentFriendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
            ->wherePivot('status', 'pending')
            ->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id')
            ->using(UserSkill::class)
            ->withTimestamps()
            ->withPivot('id');
    }

    public function jobs()
    {
        return $this->hasManyThrough(Job::class, Client::class, 'user_id', 'client_id');
    }

    public function favoriteJobs()
    {
        return $this->hasMany(FavoriteJob::class);
    }

    public function userLanguages()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function proposals()
    {
        return $this->hasManyThrough(Proposal::class, Freelancer::class, 'user_id', 'freelancer_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'from_user_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'to_user_id');
    }

    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        $path = $this->profile_photo_path;

        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, '/storage/')) {
            return asset(ltrim($path, '/'));
        }

        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    // Helper methods
    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isFreelancer(): bool
    {
        return $this->role === 'freelancer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
