<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'image', 
        'barcode', 
        'title', 
        'description', 
        'buy_price', 
        'sell_price', 
        'category_id', 
        'stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function detail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/products/'. $value),
        );
    }
}
