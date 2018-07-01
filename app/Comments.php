<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comments
 * @package App
 */
class Comments extends Model
{
    // Multi Database
    protected $connection = 'multi';
}
