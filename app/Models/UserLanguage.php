<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $table = 'user_languages';

    protected $fillable = [
        'user_id',
        'language',
        'proficiency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
