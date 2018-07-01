<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Products
 * @package App
 */
class Products extends Model
{
    // Devvending Database
    protected $connection = 'inventory';
    protected $fillable = ['account_id', 'item_id', 'item_name'];
}
