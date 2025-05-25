<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable=['fullname','email','phone','company','job_title','lead_source','status','assigned_to','notes'];
    use HasFactory;
}
