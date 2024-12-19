<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'service_type',
        'target_audience',
        'deliverables',
        'status',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    /**
     * Scope a query to only include active services.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

       /**
     * Get the portfolios related to this service.
     */
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

        /**
     * Get the clients associated with this service (optional many-to-many relationship).
     */
    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_service')->withTimestamps();
    }



}