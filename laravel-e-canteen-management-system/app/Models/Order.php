<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'notes',
        'status',
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
