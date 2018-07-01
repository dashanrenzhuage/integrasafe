<?php
/**
 * Created by PhpStorm.
 * User: Dalton
 * Date: 2/6/2018
 * Time: 12:39 AM
 */
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSubscriptions
 * @package App
 */
class ProductSubscriptions extends Model
{
    // Products Database
    protected $connection = 'products';
    protected $fillable = ['product_sku', 'stripe_plan_id', 'cost'];
}
