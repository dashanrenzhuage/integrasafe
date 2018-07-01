<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BillingAddress
 * @package App
 */
class BillingAddress extends Model
{
    // Payment Database
    protected $connection = 'payment';
    protected $table = "billing_address";
    protected $fillable = ['customer_id', 'email', 'name', 'street_address', 'city/town', 'state', 'country', 'zip_code'];
}
