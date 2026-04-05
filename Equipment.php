<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = ['name', 'total_quantity', 'available_quantity', 'rental_price', 'category_id', 'color_id'];

    public function category() { return $this->belongsTo(Category::class); }
    public function color() { return $this->belongsTo(Color::class); }
}