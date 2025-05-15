<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'overview', 'description', 'slug', 'image', 'price', 'status'];
    public function images()
    {
        return $this->hasMany(RoomTypeImage::class);
    }
}
