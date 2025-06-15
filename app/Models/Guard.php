<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guard extends Model
{
    /** @use HasFactory<\Database\Factories\GuardFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
        'dob' => 'date',
    ];
    
    protected $fillable = [
        'nric_hash',
        'nric_last4',
        'full_name',
        'dob',
        'photo_path',
        'contact_no',
        'email',
        'gender',
        'blood_type',
        'remarks',
    ];

    /**
     * Get the user account associated with the guard.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
