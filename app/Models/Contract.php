<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'proposal_id',
        'job_id',
        'client_id',
        'freelancer_id',
        'total_amount',
        'status'
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
