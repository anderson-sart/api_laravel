<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Size extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'size', 
        'size_description', 
        'status'
    ];

}
