<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class SaleItem extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'sale_items';
    protected $dates = [
        'deleted_at',
        'delivery_date'
    ]; // Garante que delivery_date é tratada como uma data

    protected $fillable = [
        'id', 
        'sale_id',
        'sale_item_code', 
        'sale_code', 
        'product_id', 
        'off_product', 
        'off_color', 
        'off_size', 
        'sequence', 
        'multiple', 
        'quantity', 
        'total_quantity', 
        'total_perc_discount', 
        'unitary_price', 
        'net_unitary_price',
        'gross_total_amount_item', 
        'total_amount_item', 
        'total_discount_amount_item', 
        'discount_percentage', 
        'delivery_date',
        'discount_percentage_type',
        'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
