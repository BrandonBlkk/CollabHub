<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function universities()
    {
        return $this->hasMany(UserUniversity::class);
    }

    public function majors()
    {
        return $this->hasMany(UserMajor::class);
    }

    public function jobs()
    {
        return $this->hasManyThrough(Job::class, Client::class, 'user_id', 'client_id');
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
