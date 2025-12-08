<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = ['contract_id', 'milestone_id', 'amount', 'status'];

    protected $casts = ['amount' => 'decimal:2'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }
}
