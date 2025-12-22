<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company',
        'website',
        'total_spent'
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    // Helpers
    public function getAllJobsAttribute()
    {
        return $this->jobs()->count();
    }

    public function getActiveJobsAttribute()
    {
        return $this->jobs()->active()->count();
    }

    public function getOpenJobsAttribute()
    {
        return $this->jobs()->where('status', 'open')->count();
    }

    public function getInProgressJobsAttribute()
    {
        return $this->jobs()->where('status', 'in_progress')->count();
    }

    public function getCompletedJobsAttribute()
    {
        return $this->jobs()->where('status', 'completed')->count();
    }

    public function getDraftJobsAttribute()
    {
        return $this->jobs()->where('status', 'draft')->count();
    }

    public function getTotalProposalsAttribute()
    {
        return $this->jobs()->withCount('proposals')->get()->sum('proposals_count');
    }
}
