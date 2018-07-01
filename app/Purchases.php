<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

/**
 * Class Payment
 * @package App
 */
class Purchases extends Model
{
    use Billable;
    protected $connection = 'payment';
    protected $table = "purchases";
    protected $fillable = ['order_id', 'stripe_id', 'transaction_id'];
}
