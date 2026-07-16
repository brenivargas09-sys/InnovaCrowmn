<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_service')
            ->withPivot(['quantity', 'subtotal', 'notes'])
            ->withTimestamps();
    }
}
