<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class University extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'country'];

    public function freelancerEducations()
    {
        return $this->hasMany(FreelancerEducation::class);
    }
}
