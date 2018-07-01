<?php
declare(strict_types=1);

namespace App\Traits;

use App\ShippingAddress;
use App\Users;


/**
 * Trait UserTrait
 * @package App\Traits
 */
trait UserTrait
{
    /**
     * Update an existing Customer or an existing User account's delivery address
     * @param String $email
     * @param String $name
     * @param String $address
     * @param String $city
     * @param String $state
     * @param String $country
     * @param String $zipcode
     */
    public function updateShipping(String $email, String $name, String $address, String $city,
                                   String $state, String $country, String $zipcode)
    {

        // Get the user (if exists) based on the email
        $user_address = ShippingAddress::select('id')->where('email', $email)->get();
        // See if the Customer has a User account  with us
        $user_id = Users::select('id')->where('email', $email)->get();
        if ((string)$user_id !== "[]") {
            $user_id = $user_id[0]['id'];
        } else {
            $user_id = null;
        }

        if ((string)$user_address !== "[]") {
            // update Shipping information
            ShippingAddress::where('email', $email)
                ->update([
                    'user_id' => $user_id,
                    'email' => $email,
                    'name' => $name,
                    'street_address' => $address,
                    'city/town' => $city,
                    'state' => $state,
                    'country' => $country,
                    'zip_code' => $zipcode
                ]);
        } else {
            // new Billing information row
            ShippingAddress::insert([
                'user_id' => $user_id,
                'email' => $email,
                'name' => $name,
                'street_address' => $address,
                'city/town' => $city,
                'state' => $state,
                'country' => $country,
                'zip_code' => $zipcode
            ]);
        }

        // Return ID of database row
        return (ShippingAddress::select('id')
            ->where('email', $email)
            ->where('name', $name)
            ->get())[0]['id'];
    }

    /**
     * Calculate the price of shipping a physical product based on the lead-time (shipping speed)
     * @param $lead_time
     * @return int
     */
    public function calculateShipping($shipping_group)
    {
        $price = 0;

        switch ($shipping_group) {
            case "0-1":
                $price = 35;
                break;
            case "2-3":
                $price = 20;
                break;
            case "3-5":
                $price = 15;
                break;
            case "5-7":
                $price = 10;
                break;
            default:
                $price = 10;
        }

        return $price;
    }
}
