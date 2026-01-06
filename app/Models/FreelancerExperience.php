<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerExperience extends Model // Changed from Pivot to Model
{
    use SoftDeletes;

    protected $table = 'freelancer_experiences';

    protected $fillable = [
        'freelancer_id',
        'job_role_id',
        'company',
        'location',
        'description',
        'is_current',
        'start_date',
        'end_date',
        'employment_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_current' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the freelancer that owns the experience.
     */
    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(Freelancer::class);
    }

    /**
     * Get the job role that owns the experience.
     */
    public function jobRole(): BelongsTo
    {
        return $this->belongsTo(JobRole::class);
    }
}
