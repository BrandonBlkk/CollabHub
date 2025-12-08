<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSkill extends Pivot
{
    use SoftDeletes;

    protected $table = 'user_skills';
    public $incrementing = true;
}
