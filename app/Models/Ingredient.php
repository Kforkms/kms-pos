<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'stock', 'unit'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_ingredient')
                    ->withPivot('qty_required')
                    ->withTimestamps();
    }
}
