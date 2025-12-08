<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    protected $fillable = ['contract_id', 'title', 'amount', 'due_date', 'status'];

    protected $casts = ['amount' => 'decimal:2', 'due_date' => 'date'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
