<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contract_id',
        'from_user_id',
        'to_user_id',
        'rating',
        'comment'
    ];

    protected $casts = ['rating' => 'decimal:2'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function to()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
