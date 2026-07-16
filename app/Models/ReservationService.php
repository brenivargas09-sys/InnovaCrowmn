<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationService extends Model
{
    protected $table = 'reservation_service';

    protected $fillable = [
        'reservation_id',
        'service_id',
        'quantity',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
