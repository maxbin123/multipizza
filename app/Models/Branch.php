<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
