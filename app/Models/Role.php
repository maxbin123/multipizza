<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMINISTRATOR = 1;
    const CUSTOMER = 2;
    const MANAGER = 3;
    const DELIVERY = 4;
    const COOK = 5;

    public $timestamps = false;

    public function users() {
        return $this->hasMany(User::class);
    }

    public function scopeBySlug(Builder $query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
