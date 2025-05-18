<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'category_id',
        'poster_id',
    ];
    public function newsCategories(){
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
    public function poster(){
        return $this->belongsTo(Admin::class, 'poster_id');
    }
}
