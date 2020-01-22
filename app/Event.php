<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'date_from', 'date_to', 'days'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'days' => 'array',
    ];

    /**
     * Get the event items associated with the event.
     */
    public function eventItems()
    {
        return $this->hasMany(EventItem::class);
    }

    /**
     * Format date_from attribute
     * @return String
     */
    public function getDateFromAttribute($value) : String
    {
        return (new \DateTime($value))->format('Y-m-d');
    }

    /**
     * Format date_to attribute
     * @return String
     */
    public function getDateToAttribute($value) : String
    {
        return (new \DateTime($value))->format('Y-m-d');
    }
}
