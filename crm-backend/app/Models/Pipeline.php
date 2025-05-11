<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    use HasFactory;
    protected $fillable = [
        'deal_title',
        'customer_name',
        'deal_value',
        'expected_close_date',
        'sales_stage',
        'assigned_to',
        'notes'
    ];
}
