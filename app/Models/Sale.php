<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id',
        'sale_code',
        'seller_id', 
        'customer_id', 
        'price_table_id', 
        'type_sale_id', 
        'brand_id', 
        'payment_term_id', 
        'user_id', 
        'carrier_id', 
        'delivery_date', 
        'gross_total_amount', 
        'total_amount', 
        'total_discount_amount', 
        'emission_date', 
        'observation', 
        'perc_desconto_1', 
        'perc_desconto_2', 
        'off_seller', 
        'off_customer', 
        'off_price_table', 
        'off_type_sale', 
        'off_brand', 
        'off_payment_term', 
        'off_user', 
        'off_carrier',
        'database_id', 
        'export_return',
        'customer_cnpj',
        'customer_email',
        'customer_contact',
        'customer_phone',
        'customer_corporate_name',
        'off_billing_type',
        'billing_type_id',
        'sale_code_online',
        'created_at',
        'updated_at',
        'status'
    ];
    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function priceTable(): BelongsTo
    {
        return $this->belongsTo(PriceTable::class);
    }

    public function typeSale(): BelongsTo
    {
        return $this->belongsTo(TypeSale::class);
    }
    
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }    
    
    public function carrier(): BelongsTo
    {
        return $this->belongsTo(carrier::class);
    }

    public function billingType(): BelongsTo
    {
        return $this->belongsTo(billingType::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    } 

    public function getFormattedEmissionDateAttribute()
    {
        return Carbon::parse($this->attributes['emission_date'])->format('d/m/Y');
    }
}
