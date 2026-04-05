<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {
    protected $fillable = ['name'];

    // Relation inverse : Un type peut avoir plusieurs événements
    public function events() {
        return $this->hasMany(Event::class);
    }
}