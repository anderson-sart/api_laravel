<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'product',
        'product_description',
        'product_code',
        'color', 
        'size', 
        'list_multiples', 
        'bar_code', 
        'brand_id',  
        'type_sale',
        'status'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function files()
    {
        return $this->hasMany(Asset::class, 'product', 'product');
    }

}
