<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'title',
        'description',
        'type',
        'status',
        'budget_min',
        'budget_max',
        'duration',
        'experience_level',
        'skills_required',
        'category_id',
        'posted_at',
        'expires_at',
        'is_featured',
        'is_private',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'posted_at'      => 'datetime',
        'expires_at'     => 'datetime',
        'budget_min'     => 'decimal:2',
        'budget_max'     => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_private'   => 'boolean',
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function favoriteJobs()
    {
        return $this->hasMany(FavoriteJob::class);
    }

    // Helper: Display budget like in your UI
    public function getBudgetDisplayAttribute(): string
    {
        if ($this->type === 'fixed' && $this->budget_min) {
            return '$' . number_format($this->budget_min);
        }

        if ($this->budget_min && $this->budget_max) {
            return '$' . number_format($this->budget_min) . ' - $' . number_format($this->budget_max);
        }

        return 'Negotiable';
    }

    // Helper: "Posted X ago"
    public function getPostedAgoAttribute(): string
    {
        return $this->posted_at?->diffForHumans() ?? 'Just now';
    }

    // Scope: Only active jobs
    public function scopeActive($query)
    {
        return $query->where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    // Scope: Featured jobs
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getAllCategoriesAttribute()
    {
        return $this->category->ancestorsAndSelf()->pluck('id')->toArray();
    }
}
