<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Seller extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'seller', 
        'cpf_cnpj', 
        'corporate_name',
        'nickname',
        'email',
        'phone',
        'city',
        'status'
    ];

}
