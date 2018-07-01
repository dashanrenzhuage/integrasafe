<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orders
 * @package App
 */
class ProductInventory extends Model
{
    // CustomPCB Database
    protected $connection = 'products';
    protected $table = "inventory";
    protected $fillable = ['product_sku', 'inventory'];
}