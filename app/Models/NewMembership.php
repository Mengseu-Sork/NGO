<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name_en', 'org_name_kh', 'membership_type', 'director_name', 'director_email',
        'director_phone', 'alt_phone', 'website', 'social_media', 'representative_name',
        'representative_email', 'representative_phone', 'representative_position','user_id', 
    ];

    public function membershipUploads()
    {
        return $this->hasMany(MembershipUpload::class);
    }

    // The user who created the membership
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
