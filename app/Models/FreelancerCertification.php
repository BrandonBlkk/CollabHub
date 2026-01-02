<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreelancerCertification extends Model
{
    use SoftDeletes;

    // Add this line to specify the correct table name
    protected $table = 'freelancer_certifications';

    protected $fillable = [
        'freelancer_id',
        'name',
        'issuer',
        'certificate_url',
        'issued_year',
        'expiry_year',
    ];

    protected $casts = [
        'issued_year' => 'integer',
        'expiry_year' => 'integer',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
}
