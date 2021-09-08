<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
