<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PENDING = 1, STATUS_IN_TRANSACTION = 2, STATUS_SUCCESS = 3, STATUS_FAILURE = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'payment_type_id',
        'payment_detail_2c2p_id',
        'stripe_payment_method_id',
        'amount',
        'status',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class);
    }

    public function paymentDetail2c2p(){
        return $this->belongsTo(PaymentDetail2c2p::class, 'payment_detail_2c2p_id');
    }

}
