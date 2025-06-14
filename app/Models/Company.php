<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
    'license_expiry' => 'date',
];

    protected $fillable = [
        'name',
        'license_no',
        'license_expiry',
        'address',
        'status',
    ];


}
