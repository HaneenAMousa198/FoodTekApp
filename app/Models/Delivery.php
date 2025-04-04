<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model {
    protected $fillable = [
        'order_id', 
        'staff_id', 
        'driver_name', 
        'status', 
        'status_time', 
        'delivery_address'
    ];
    public function order() 
    { 
        return $this->belongsTo(Order::class); 
    }
    public function staff() 
    { 
        return $this->belongsTo(Staff::class); 
    }
}
