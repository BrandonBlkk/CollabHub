<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserUniversity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'university_id',
        'degree',
        'graduation_year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
