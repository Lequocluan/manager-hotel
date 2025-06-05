<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'check_in_date',
        'check_out_date',
        'status',
        'notes',
        'total_price',
        'payment_status',
        'payment_method'
    ];
    protected $casts = [
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
        'total_price' => 'decimal:2',
        'payment_method' => 'boolean',
    ];
    public function bookingServices()
    {
        return $this->hasMany(BookingService::class, 'booking_id');
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_rooms', 'booking_id', 'room_id') -> withPivot('price_per_night', 'number_of_nights');
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services', 'booking_id', 'service_id');
    }
}
