<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'date'];

    /**
     * Get the parent event related with this item.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Format date attribute
     * @return String
     */
    public function getDateAttribute($value) : String
    {
        return (new \DateTime($value))->format('Y-m-d');
    }
}
