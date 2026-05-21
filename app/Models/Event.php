<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'registrations');
    }

    /**
     * Use uuid for route key
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Generate UUID on creation
     */
    protected static function booted()
    {
        static::creating(function ($event) {
            $event->uuid = (string) Str::uuid();
        });
    }
}
