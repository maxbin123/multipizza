<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Malhal\Geographical\Geographical;

class Restaurant extends Model
{
    use HasFactory, Geographical;

    const DISTANCE_LIMIT = 4;
    protected static $kilometers = true;

    protected $with = [
        'branch',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected static function booted()
    {
        // Client passes his coordinates in header, distance limit automatically applied
        static::addGlobalScope('geofenced', function (Builder $query) {
            $longitude = request()->header('X-Location-Longitude');
            $latitude = request()->header('X-Location-Latitude');
            if ($longitude && $latitude && !request()->query('full')) {
                $query->geofence(floatval($longitude), floatval($latitude), 0, self::DISTANCE_LIMIT);
            }
        });
    }
}
