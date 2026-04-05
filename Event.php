<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Event extends Model {
    protected $fillable = ['title', 'client_name', 'type', 'event_date', 'duration_days', 'budget'];
   /* public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }*/
}