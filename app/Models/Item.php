<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function itemable()
    {
        return $this->morphTo();
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('price');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute($value)
    {
        return is_null($value) ? $this->product->name : $value;
    }

    public function getPriceAttribute($value)
    {
        return is_null($value) ? $this->product->price : $value;
    }

    public function getSumAttribute($value)
    {
        $ingredients_sum = $this->ingredients->sum('pivot.price');
        $item_sum = $this->price * $this->quantity;

        return $ingredients_sum + $item_sum;
    }
}
