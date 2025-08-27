<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter','constitution','activities','funding',
        'registration','strategic_plan','fundraising_strategy',
        'audit_report','goal','signature'
    ];

    public function networks()
    {
        return $this->hasMany(Network::class);
    }

    public function focalPoints()
    {
        return $this->hasMany(FocalPoints::class);
    }
}
