<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * @param $payments
     * @return array|mixed
     * Cast Payments field.
     */
    public function getPaymentsAttribute($payments)
    {
        return $payments ? json_decode($payments, true) : [];
    }

    /**
     * @param $courier
     * @return array|mixed
     * Cast courier field.
     */
    public function getCourierAttribute($courier)
    {
        return $courier ? json_decode($courier, true) : [];
    }
}
