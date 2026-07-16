<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'status',
        'total_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'reservation_service')
            ->withPivot(['quantity', 'subtotal', 'notes'])
            ->withTimestamps();
    }

    public function reservationServices()
    {
        return $this->hasMany(ReservationService::class);
    }

    public function getNightsAttribute(): int
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    public function getTotalServicesAttribute(): float
    {
        return $this->reservationServices->sum('subtotal');
    }

    public function getGrandTotalAttribute(): float
    {
        return $this->total_amount + $this->total_services;
    }
}
