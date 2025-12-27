<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FeedingLog extends Model
{
    protected $fillable = [
        'type',
        'start_time',
        'end_time',
        'quantity_ml',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected function durationMinutes(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->end_time && $this->start_time) {
                    return $this->start_time->diffInMinutes($this->end_time);
                }
                return null;
            }
        );
    }
}
