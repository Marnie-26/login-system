<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkPermit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'unit_no',
        'resident_name',
        'work_scope',
        'date_from',
        'date_to',
        'contractor_name',
        'contact_person',
    ];
}
