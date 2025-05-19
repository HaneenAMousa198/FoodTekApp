<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',      // يشير إلى جدول staff أو users ذوي دور driver
        'staff_id',
        'status',         // pending ‑ on_the_way ‑ delivered
        'status_time',
        'delivered_address',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
    ];

    /* العلاقات */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(Staff::class, 'driver_id');
    }
}
