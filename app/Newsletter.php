<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Products
 * @package App
 */
class Newsletter extends Model
{
    // Devvending Database
    protected $connection = 'multi';
    protected $table = 'newsletter';
    protected $fillable = ['email', 'beta_tester', 'newsletter'];
}
