<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    protected $table = 'profile_views';

    protected $fillable = [
        'profile_user_id',
        'viewer_id',
        'viewer_ip',
        'user_agent',
        'referrer',
        'is_logged_in',
    ];

    public function profileUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
