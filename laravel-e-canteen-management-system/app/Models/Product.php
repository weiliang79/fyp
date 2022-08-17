<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'barcode',
        'price',
        'status',
        'store_id',
        'category_id',
    ];

    public function Store(){
        return $this->belongsTo(Store::class);
    }

    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function productOptions(){
        return $this->hasMany(ProductOption::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orderDetail(){
        return $this->belongsTo(OrderDetail::class);
    }
}
