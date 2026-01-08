<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreelancerEducation extends Model
{
    use SoftDeletes;

    protected $table = 'freelancer_educations';

    protected $fillable = [
        'user_id',
        'university_id',
        'major_id',
        'degree',
        'start_year',
        'end_year',
        'field_of_study',
        'grade',
        'description',
        'is_current',
    ];

    protected $cast = [
        'start_year' => 'integer',
        'end_year' => 'integer',
        'is_current' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
