<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Use $fillable for explicit security control.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Accessor for formatted price (USD).
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2);
    }

    /**
     * Accessor for EUR price using cached exchange rate (optional).
     * This assumes exchange rate will be passed or set elsewhere.
     */
    public function getPriceInEur(float $exchangeRate): string
    {
        return number_format($this->price * $exchangeRate, 2);
    }

    /**
     * Default product image accessor.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image 
            ? asset($this->image)
            : asset('images/product-placeholder.jpg');
    }
}
