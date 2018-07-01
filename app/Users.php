<?php
declare(strict_types=1);

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Multi
 * @package App
 */
class Users extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    protected $connection = 'multi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'token',
    ];

    /**
     * Assign a user a role by providing a role name.
     *
     * @param string $role_name
     */
    public function assignRole(string $role_name)
    {
        $role = Roles::whereName($role_name)->first();
        return $this->roles()->attach($role);
    }

    public function roles()
    {
        return $this->belongsToMany('App\Roles');
    }

    /**
     * @param $role
     * @return int
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function social()
    {
        return $this->hasMany('App\SocialLogins');
    }

    public function homeUrl()
    {
        return route('/');
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) {
                return true;
            }
        }

        return false;
    }
}
