<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'capacity',
        'image',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'capacity' => 'integer',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
