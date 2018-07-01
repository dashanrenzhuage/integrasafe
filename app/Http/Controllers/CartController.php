<?php
declare(strict_types=1);

namespace App\Http\Controllers;

// Classes
use App\Classes\CookieMonster;
use App\ProductSkus;
use App\StripeProducts;
use App\Traits\ProductsTrait;
use App\Traits\StripeTrait;
use App\Traits\UserTrait;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

/**
 * Extends Controller
 *
 * Uses StripeTrait, UserTrait, ProductsTrait
 *
 * Class CartController
 * @package App\Http\Controllers
 */
class CartController extends Controller
{
    use StripeTrait;
    use UserTrait;
    use ProductsTrait;

    private $cookies;

    /**
     * CartController constructor.
     * @param CookieJar $cookiejar
     */
    public function __construct(CookieJar $cookiejar)
    {
        // Set the CookieJar (which holds methods)
        $this->cookies = new CookieMonster($cookiejar);
        $this->cookiejar = $cookiejar;
    }

    /**
     * Add a Product SKU to a User's cart
     * @param Request $request
     * @return array
     */
    public function addToCart(Request $request)
    {
        try {
            $product = ($request->all())['product'];

            if (!isset($_COOKIE["user_cart"])) {
                $this->cookies->createCookie("user_cart", [$product => 1]);
            } else {
                $old_products = $this->cookies->getCookie("user_cart");
                if (array_key_exists($product, $old_products)) {
                    // If the same product is added to the cart, update the quantity
                    $old_products[$product] = $old_products[$product] + 1;
                    $new_products = $old_products;
                } else {
                    // If the User has already added items to their cart, merge them with the newly added product
                    $new_products = array_merge([$product => 1], $old_products);
                }

                $this->cookies->updateCookie("user_cart", $new_products);
            }

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The User has added the SKU `' . $product . "` to their cart",
                'logger' => 'info',
            ]);

            $sku = (ProductSkus::select('product_id', 'price')
                ->where('product_sku', $product)
                ->get())[0];

            $sku_parent_name = (StripeProducts::select('name')->where('id', $sku['product_id'])->get())[0]['name'];

            $full_product = [$sku_parent_name, substr($sku['price'], 0, -2)];

            return ["true", $full_product];
        } catch (\Exception $except) {

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The user encountered an error adding a SKU to their cart. Error: ' . $except,
                'logger' => 'error',
            ]);

            return ["false"];
        }
    }

    /**
     * Remove a Product SKU to a User's cart
     * @param Request $request
     * @return bool
     */
    public function removeFromCart(Request $request)
    {
        try {
            $product = ($request->all())['product'];

            if (!isset($_COOKIE["user_cart"])) {
                return "false";
            } else {
                // Remove key-value pair from Cart array
                $cart = $this->cookies->getCookie("user_cart");
                unset($cart[$product]);

                if ($cart === []) {
                    // If there is no more products left in the cart after the latest removal, delete the Cookie Cart
                    $this->cookies->deleteCookie("user_cart");
                } else {
                    // Else return what's left of the Cart
                    $this->cookies->updateCookie("user_cart", $cart);
                }
            }

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The User has removed the SKU `' . $product . '` from their cart',
                'logger' => 'info',
            ]);

            return "true";
        } catch (\Exception $except) {

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The user encountered an error removing a SKU from their cart. Error: ' . $except,
                'logger' => 'error',
            ]);

            return "false";
        }
    }

    /**
     * Updates the quantity of a Product SKU in the User's cart
     * @param Request $request
     * @return bool
     */
    public function updateCart(Request $request)
    {
        try {
            $product = ($request->all())['product'];
            $quantity = ($request->all())['quantity'];

            if (!isset($_COOKIE["user_cart"])) {
                return "false";
            } else {
                $old_products = $this->cookies->getCookie("user_cart");
                if (array_key_exists($product, $old_products)) {
                    // If the same product is added to the cart, update the quantity
                    $old_products[$product] = $quantity;
                    $new_products = $old_products;
                } else {
                    return "false";
                }

                $this->cookies->updateCookie("user_cart", $new_products);
            }

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The User has added the SKU `' . $product . "` to their cart",
                'logger' => 'info',
            ]);

            return "true";
        } catch (\Exception $except) {

            // Update Sentry on the SKUs the Customer has selected to purchase
            app('sentry')->breadcrumbs->record([
                'message' => 'The user encountered an error adding a SKU to their cart. Error: ' . $except,
                'logger' => 'error',
            ]);

            return "false";
        }
    }

    /**
     * Return an array of all the SKU information of a User's Cart
     * @return array
     */
    public function getCart()
    {
        try {
            // Get the User's currently selected Cart SKUs
            $cart_skus = $this->cookies->getCookie("user_cart");
            $selected_skus = $this->getSkuInformation($cart_skus, true, true);
        } catch (\Exception $except) {
            $selected_skus = [];
        }

        return $selected_skus;
    }
}
