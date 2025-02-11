<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'jersey_name',
        'jersey_number',
        'size',
        'remarks',
        'order_number',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    public function user(){
        return $this->hasOne(UserFiend::class, 'id', 'user_id');
    }
}
