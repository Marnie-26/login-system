<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guests extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'visit_purpose',
        'visit_date',
        'image',
        'time_in',
        'time_out',
    ];
}
