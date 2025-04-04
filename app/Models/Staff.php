<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'user_id'
    ];
    public function user() 
    { 
        return $this->belongsTo(User::class); 
    }
    public function deliveries() 
    { 
        return $this->hasMany(Delivery::class); 
    }
    public function chats() 
    { 
        return $this->hasMany(Chat::class); 
    }
    public function calls() 
    { 
        return $this->hasMany(Call::class); 
    }
}
