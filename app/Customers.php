<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

/**
 * Class Payment
 * @package App
 */
class Customers extends Model
{
    use Billable;
    protected $connection = 'payment';
    protected $table = "customers";
    protected $fillable = ['user_id', 'email', 'stripe_id'];
}
