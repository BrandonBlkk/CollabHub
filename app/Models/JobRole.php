<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobRole extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'popularity',
        'is_active',
        'category_id',
    ];

    protected $casts = [
        'popularity' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the category that owns the job role.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the freelancers that have this job role in their experience.
     */
    public function freelancers(): BelongsToMany
    {
        return $this->belongsToMany(
            Freelancer::class,
            'freelancer_experiences',
            'job_role_id',
            'freelancer_id'
        )
            ->using(FreelancerExperience::class)
            ->withPivot([
                'company',
                'location',
                'description',
                'is_current',
                'start_date',
                'end_date',
                'employment_type',
                'created_at',
                'updated_at',
                'deleted_at',
            ])
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }
}
