<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'service',
        'budget_range',
        'project_details',
        'privacy_agreed',
    ];
    
    
    protected $casts = [
        'privacy_agreed' => 'boolean'
    ];
}