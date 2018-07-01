<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orders
 * @package App
 */
class ProductSkus extends Model
{
    // CustomPCB Database
    protected $connection = 'products';
    protected $table = "product_skus";
    protected $fillable = ['product_id', 'product_sku', 'price', 'width', 'length', 'height', 'weight'];
}