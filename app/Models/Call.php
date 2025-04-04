<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model {
    protected $fillable = [
        'user_id', 
        'staff_id'
    ];
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    public function staff() 
    { 
        return $this->belongsTo(Staff::class); 
    }
}
