<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Tyler
 * Date: 7/19/2017
 * Time: 8:59 PM
 */

namespace App\Classes;

use App\Accounts;
use App\Users;

/**
 * Class Entity
 * @package App\Classes
 */
class Entity
{
    /**
     * @param $id
     * @return mixed
     */
    public function account($id)
    {
        $account = Accounts::find($id);
        $account->primary_user = Users::find($account->primary_user_id);
        $account->primary_user->phone = preg_replace(
                '~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '+1 ($1) $2-$3', $account->primary_user->phone
            ) . "\n";
        $account->users = Users::where('account_id', $account->id)->get();

        return $account;
    }
}
