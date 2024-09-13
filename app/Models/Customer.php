<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Customer extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'customer', 
        'cpf_cnpj', 
        'corporate_name',
        'nickname',
        'email',
        'phone',
        'city',
        'expired_financial_title',
        'select contato from cliente',
        'status'
    ];

}
