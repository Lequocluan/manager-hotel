<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'room_type_id',
        'description',
        'status',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    const STATUS_TEXT = [
        0 => 'Trống',
        1 => 'Đã đặt',
        2 => 'Bảo trì',
    ];

    public function getStatusTextAttribute()
    {
        return self::STATUS_TEXT[$this->status] ?? 'Không rõ';
    }
}
