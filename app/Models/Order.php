<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $fillable = [
        'address',
        'user_id',
        'quantity',
        'product_id',
    ];

    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
