<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'shift_id',
        'customer_name',
        'order_type',
        'total_amount',
        'discount',
        'payment_method',
        'paid_amount',
        'change_amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
