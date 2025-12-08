<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMajor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'major_id',
        'start_year',
        'end_year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
