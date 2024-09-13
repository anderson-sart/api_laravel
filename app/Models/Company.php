<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Company extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'id', 
        'company', 
        'cpf_cnpj', 
        'company_name',
        'nickname',
        'email',
        'phone',
        'city',
        'event_description',
        'status' 
    ];
}
