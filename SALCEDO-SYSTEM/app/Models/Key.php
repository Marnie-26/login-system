<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Key extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unit_no',
        'authorized_by',
        'contractor_name',
        'borrow_purpose',
        'borrow_date',
        'time_borrowed',
        'time_returned',
    ];
}
