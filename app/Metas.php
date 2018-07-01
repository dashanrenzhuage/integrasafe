<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Metas
 * @package App
 */
class Metas extends Model
{
    // Multi Database
    protected $connection = 'multi';
    protected $fillable   = ['user_id', 'phone_number', 'gender'];
}
