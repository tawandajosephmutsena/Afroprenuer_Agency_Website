<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'client_id',
        'service_id',
        'completion_date',
        'status',
        'url',
        'gallery',



    ];

    protected $casts = [
        'gallery' => 'array',
        'completion_date' => 'date',
        'status' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
