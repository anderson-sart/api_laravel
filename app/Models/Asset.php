<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Filterable;

class Asset extends Model
{
    use HasFactory, SoftDeletes, Filterable;
    protected $fillable = [
        'id',
        'asset',
        'md5', 
        'filename', 
        'size', 
        'uploadDate', 
        'product',  
        'color',  
        'link_filename',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
