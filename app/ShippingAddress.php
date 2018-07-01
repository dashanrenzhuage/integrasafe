<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingAddress
 * @package App
 */
class ShippingAddress extends Model
{
    // User Database
    protected $connection = 'multi';
    protected $table = "shipping_address";
    protected $fillable = ['user_id', 'email', 'name', 'street_address', 'city/town', 'state', 'country', 'zip_code'];
}
