<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_type_id',
        'amount',
        'reference',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class);
    }
}
