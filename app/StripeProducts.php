<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orders
 * @package App
 */
class StripeProducts extends Model
{
    // CustomPCB Database
    protected $connection = 'products';
    protected $table = "products";
    protected $fillable = ['stripe_product_id', 'name', 'caption', 'description', 'status', 'shippable', 'purchasable_url'];
}