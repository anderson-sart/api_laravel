<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class UserSeller extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'user_seller';

    protected $fillable = [
        'id', 
        'seller', 
        'user',
        'status'
    ];
}
