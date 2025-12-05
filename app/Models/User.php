<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'profile_photo_path',
        'phone',
        'bio',
        'location',
        'skills',
        'hourly_rate',
        'company',
        'website',
        'status',
        'completed_projects',
        'total_earned',
        'total_spent',
        'rating',
        'rating_count',
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
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'rating' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_spent' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
    ];
}
