<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailStripe extends Model
{
    use HasFactory;

    protected $table = 'payment_details_stripe';

    protected $fillable = [
        'amount',
        'payment_method_types',
        'transaction_time',
        'status',
    ];

    protected $casts = [
        'payment_method_types' => 'array',
    ];

    public function payment(){
        return $this->hasOne(Payment::class, 'payment_detail_stripe_id', 'id');
    }
}
