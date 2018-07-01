<?php
declare(strict_types=1);

namespace App\Classes;

/**
 * Laravel classes
 */
use Illuminate\Cookie\CookieJar;

/**
 * Class Cookies
 * @package App\Classes
 */
class CookieMonster
{
    /**
     * @var $CookieJar
     */
    private $cookiejar;

    /**
     * CookieJar constructor.
     * @param CookieJar $jar
     */
    public function __construct(CookieJar $jar)
    {
        // Create a new Queue to hold Cookies
        $this->cookiejar = $jar;

        // Set default path and domain to the current website, and give it the Secure Flag
        $this->cookiejar->setDefaultPathAndDomain('/', '', true);
    }

    /**
     * Create Laravel Cookie.
     * @param String $cookie_name
     * @param $cookie_values
     * @param $duration (@optional)
     * @return \Symfony\Component\HttpFoundation\Cookie Cookie
     */
    public function createCookie($cookie_name, $cookie_values, $duration = null)
    {
        // If this method is called without a Cookie duration, then set a default duration of 7 Day
        if ($duration === null) {
            // 7 day | (24hrs * 7)
            $duration = 10850;
        }

        // Create the normal Laravel Cookie, ready to be Queued in the CookieJar
        $cookie = $this->cookiejar->make(
            $cookie_name, $cookie_values, $duration, '/', '', true, true
        );

        // Add the Cookie to the CookieJar to be sent with the next Request
        $this->cookiejar->queue($cookie);

        // Return the Cookie Object
        return $cookie;
    }

    /**
     * Update a current Laravel Cookie.
     * @param String $cookie_name
     * @param $cookie_values
     * @param $duration (@optional)
     * @return \Symfony\Component\HttpFoundation\Cookie Cookie
     */
    public function updateCookie($cookie_name, $cookie_values, $duration = null)
    {
        // Check to see if there is a Cookie by that name, if not, then only create the Cookie
        if (isset($_COOKIE[$cookie_name])) {
            // Delete the current version of the Cookie with the $cookie_name
            self::deleteCookie($cookie_name);
        }

        // Create a new Cookie with the newer values
        return self::createCookie($cookie_name, $cookie_values, $duration);
    }

    /**
     * Delete a Laravel Cookie.
     * @param String $cookie_name
     */
    public function deleteCookie($cookie_name)
    {
        // Check if the Cookie has been placed in the Queue to been sent with the next request
        if ($this->cookiejar->hasQueued(($cookie_name))) {
            // If it has been queued but not sent, remove it from the Queue
            $this->cookiejar->unqueue(($cookie_name));
        }

        // Updates the Cookie's duration to be in the past, thus manually expiring the Cookie
        $deleted_cookie = $this->cookiejar->forget($cookie_name);
        // Add the expired Cookie to the Queue, this "updates" the Client-side Cookie to the now expired Laravel Cookie
        $this->cookiejar->queue($deleted_cookie);
    }

    /**
     * Get a Laravel Cookie.
     * @param String $cookie_name
     * @return array $value
     */
    public function getCookie($cookie_name)
    {
        // Check if there is a Cookie (under the given name) present
        if (isset($_COOKIE[$cookie_name])) {
            // If there IS one, grab the Cookie's encrypted value and decrypt it for readability
            $cookie = decrypt($_COOKIE[$cookie_name]);

            // If the Cookie was recently created and is still in the Queue, waiting to be sent with the next request,
        } elseif ($this->cookiejar->hasQueued($cookie_name)) {
            // Then go ahead and grab that Cookie's (non-encrypted) value for use immediately.
            $cookie = $this->cookiejar->queued($cookie_name)->getValue();
        } else {
            $cookie = [];
        }

        return $cookie;
    }

    /**
     * Check the quantity of SKUs in the Cart
     * (Cart implementation only)
     * @return int|string
     */
    public function checkCookieCart()
    {
        if (!isset($_COOKIE['user_cart'])) {
            return "";
        } else {
            // Multidimensional array containing a SKU Key and a quantity Value (key-value pair)
            $cart = $this->getCookie("user_cart");
            // Get all the keys of the Cart array
            $cart_keys = array_keys($cart);

            $count = 0;
            for ($counter = 0; $counter < count($cart_keys); $counter++) {
                // Count the number of items the User has selected
                $count = $count + $cart[$cart_keys[$counter]];
            }

            return "data-badge=" . $count;
        }
    }

    /**
     * Get the quantity of a SKU in a Customer's cart
     * @param String $product_sku
     * @return int
     */
    public function getCartItemQuantity(String $product_sku)
    {
        $quantity = 0;

        if (isset($_COOKIE["user_cart"])) {
            $cart_skus = $this->getCookie("user_cart");
            if (array_key_exists($product_sku, $cart_skus)) {
                // If the same product is added to the cart, update the quantity
                $quantity = $cart_skus[$product_sku];
            }
        }

        return $quantity;
    }
}
