<?php
/**
 * Created by PhpStorm.
 * User: Dalton
 * Date: 7/27/2017
 * Time: 11:44 AM
 */
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscriptions
 * @package App
 */
class Subscriptions extends Model
{
    // Payment Database
    protected $connection = 'payment';
    protected $fillable = ['user_id', 'email', 'customer_id', 'plan_id', 'quantity', 'trial_ends_at', 'ends_at'];
}
