<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class TypeSale extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id', 'type_sale', 'type_sale_description', 'status'
    ];
}
