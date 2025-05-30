<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'overview', 
        'description', 
        'slug', 
        'image', 
        'price', 
        'max_adults',
        'max_children',
        'bed_type',
        'size',
        'status',
    ];

    protected $attributes = [
        'max_adults' => 2,
        'max_children' => 2,
    ];

    public function images()
    {
        return $this->hasMany(RoomTypeImage::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

}