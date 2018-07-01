<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Roles
 *
 * @package App
 */
class UserRoles extends Model
{
    // Multi Database
    protected $connection = 'multi';
    protected $table = 'roles_users';
    protected $fillable = ['users_id', 'roles_id'];
}
