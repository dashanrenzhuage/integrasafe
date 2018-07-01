<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Orders
 * @package App
 */
class ProductTags extends Model
{
    // CustomPCB Database
    protected $connection = 'products';
    protected $table = "tags";
    protected $fillable = ['product_id', 'tag', 'description'];
}