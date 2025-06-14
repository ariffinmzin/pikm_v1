<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guard extends Model
{
    /** @use HasFactory<\Database\Factories\GuardFactory> */
    use HasFactory, SoftDeletes;
}
