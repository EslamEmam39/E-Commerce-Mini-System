<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
    ];
    public function  user() : BelongsTo {
         return $this->belongsTo(User::class);
    }
    
    public function  address() : BelongsTo {
         return $this->belongsTo(Address::class);
    }



    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
