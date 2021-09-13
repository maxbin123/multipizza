<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;

class Product extends Model
{
    use HasFactory;
    use BelongsToThrough;

    protected $with = [
        'category',
        'branch'
    ];

    public function category() {
        return $this->belongsTo(Category::class)->with('branch');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('price');
    }

    public function branch()
    {
        return $this->belongsToThrough(Branch::class, Category::class);
    }

}
