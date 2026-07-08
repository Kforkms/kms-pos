<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'stock', 'image', 'category', 'image_url'];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredient')
                    ->withPivot('qty_required')
                    ->withTimestamps();
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_product')
                    ->withPivot('qty')
                    ->withTimestamps();
    }
}
