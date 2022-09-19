<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const PAYMENT_PENDING = 1, PAYMENT_IN_PROGRESS = 2, PAYMENT_SUCCESS = 3, PAYMENT_FAIL = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'pick_up_start',
        'pick_up_end',
        'total_price',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pick_up_start' => 'datetime',
        'pick_up_end' => 'datetime',
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
