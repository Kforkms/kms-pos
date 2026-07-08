<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'price', 'image_url', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'package_product')
                    ->withPivot('qty')
                    ->withTimestamps();
    }
}
