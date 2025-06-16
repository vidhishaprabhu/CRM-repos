<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'name',
        'submit_message',
        'logo',
        'fields'
    ];

    protected $casts = [
        'fields' => 'array',
    ];
}
