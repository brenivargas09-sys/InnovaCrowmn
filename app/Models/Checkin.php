<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $fillable = [
        'reservation_id',
        'actual_check_in',
        'actual_check_out',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'actual_check_in' => 'datetime',
        'actual_check_out' => 'datetime',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
