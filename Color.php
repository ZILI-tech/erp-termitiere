<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // Relation : Une couleur peut être attribuée à plusieurs équipements
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
}