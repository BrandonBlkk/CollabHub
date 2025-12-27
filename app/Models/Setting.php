<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'language',
        'timezone',
        'currency',
        'dark_mode',
        'email_project_updates',
        'email_new_messages',
        'email_payments',
        'email_marketing',
        'profile_visibility',
        'show_online_status',
        'show_earnings'
    ];

    protected $casts = [
        'dark_mode' => 'boolean',
        'email_project_updates' => 'boolean',
        'email_new_messages' => 'boolean',
        'email_payments' => 'boolean',
        'email_marketing' => 'boolean',
        'show_online_status' => 'boolean',
        'show_earnings' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
