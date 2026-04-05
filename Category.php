<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relation : Une catégorie contient plusieurs équipements
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
}