<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    protected $fillable = ['job_id', 'freelancer_id', 'proposal_text', 'bid_amount', 'estimated_timeline'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
