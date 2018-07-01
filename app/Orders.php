<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orders
 * @package App
 */
class Orders extends Model
{
    // Payment Database
    protected $connection = 'payment';
    protected $table = "orders";
    protected $fillable = ['status', 'product_id', 'billing_address', 'shipping_address', 'discount',
        'price_after_discount', 'shipping_speed', 'order_chain'];
}
