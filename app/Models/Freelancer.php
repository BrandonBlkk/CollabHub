<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Freelancer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'bio',
        'hourly_rate',
        'job_title',
        'availability',
        'years_experience',
        'portfolio_url',
        'social_links',
        'languages',
        'response_time',
        'working_hours',
        'total_projects',
        'job_success_rate',
        'total_hours',
        'completed_projects',
        'total_earned',
        'rating',
        'rating_count'
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'job_success_rate' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'rating' => 'decimal:2',
        'social_links' => 'array',
        'languages' => 'array',
        'working_hours' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
