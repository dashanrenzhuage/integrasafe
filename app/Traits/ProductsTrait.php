<?php
declare(strict_types=1);

namespace App\Traits;

use App\ProductInventory;
use App\ProductSkus;
use App\StripeProducts;
use Illuminate\Http\Request;


/**
 * Trait ProductsTrait
 * @package App\Traits
 */
trait ProductsTrait
{

    /**
     * Checks to see if a SKU's ID is present in a POST Request
     * @param Request $request
     * @return array
     */
    public function getSelectedSkus(Request $request)
    {
        $selected = [];
        // Get all available product skus and their price
        $product_skus = ProductSkus::select('id', 'product_id', 'product_sku', 'price')->get();

        // Loop through all available skus
        foreach ($product_skus as $product_sku) {
            $sku = $product_sku['product_sku'];
            // See if Sku was in the submitted form
            if (isset($request[$sku])) {
                // Product was select in Purchase Form, add to selected list
                array_push($selected, $product_sku);
            }
        }

        return $selected;
    }

    /**
     * Performs an API call to Stripe after an Order has been charged and paid for
     * to get the, now updated, SKU Inventory amount and updates our database inventory to match
     * @param String $product_sku
     * @param int $quantity
     * @return bool|string
     */
    public function updateSkuInventory(String $product_sku)
    {
        // Get SKU's ID
        $sku_id = (ProductSkus::select('id')
            ->where('product_sku', $product_sku)
            ->get())[0];

        // Get Stripe's updated SKU inventory (after Order has been purchased)
        $stripe_sku = \Stripe\SKU::retrieve($product_sku);
        $new_inventory = $stripe_sku["inventory"];

        // Update the inventory to reflect the new amount
        return ProductInventory::where('id', $sku_id['id'])
            ->update([
                'inventory' => $new_inventory
            ]);
    }

    /**
     * Calculates the total price of the SKUs selected by the Customer
     * (not including Tax, Shipping Fees, or Subscription fees)
     * @param $cookieCart
     * @return int
     */
    public function calculateSkuPrice($cookieCart)
    {
        $total = 0;

        // Get the SKUs from the Cookie Cart
        $cart_skus = $cookieCart->getCookie("user_cart");

        // Cart is not empty
        if ($cart_skus !== []) {
            // Get all information of a SKU and it's Parent product
            $selected_skus = $this->getSkuInformation($cart_skus, true, true);

            // Calculate Total
            for ($counter = 0; $counter < count($selected_skus); $counter++) {
                $total = $total + $selected_skus[$counter]['price'];
                // For multiple quantities of the same product
                for ($sub_counter = 1; $sub_counter < $selected_skus[$counter]['quantity']; $sub_counter++) {
                    // Start at 1 because we've already added the price of one to the total, we just need to add the rest
                    $total = $total + $selected_skus[$counter]['price'];
                }
            }
        }

        return $total;
    }

    /**
     * (Original) Given an array of Product SKUs, get their associated Parent Product's details
     *
     * (Cart) Given a multidimensional array, i.e. the Cookie Cart, and the $multi and $optional flags set to true,
     * this function will get the keys of the Cart and perform the same operation as the Original.
     * @param $product_skus
     * @param bool $optional
     * @return array
     */
    public function getSkuInformation($product_skus, $optional = false, $multi = false)
    {
        $final_skus = [];

        if ($multi === true) {
            $product_array = array_keys($product_skus);
        } else {
            // multidimensional array was  not given
            $product_array = $product_skus;
        }

        foreach ($product_array as $sku) {
            // If only the product_sku is stored, get the rest of the data associated with it
            if ($optional === true) {
                $sku = [(ProductSkus::select('id', 'product_id', 'product_sku', 'price')
                    ->where('product_sku', $sku)
                    ->get())[0]][0];
            }

            // Get the Product SKU's name
            $sku->name = (StripeProducts::select('name')->where('id', $sku['product_id'])->get())[0]['name'];
            // Get the available inventory of the SKU
            $sku->stock = (ProductInventory::select('inventory')->where('product_sku', $sku['id'])->get())[0]['inventory'];
            // Convert price into dollars from cents
            $sku->price = substr($sku->price, 0, -2);
            // Get an associated plan
            $subscription = $this->checkForSubscription($sku->product_sku);
            if ($subscription !== [] || $subscription !== false) {
                $sku->subscription = $subscription;
            } else {
                $sku->subscription = "No Subscription Plan";
            }

            // Add the quantity back into the object
            if ($multi === true) {
                $sku->quantity = $product_skus[$sku['product_sku']];
            }

            array_push($final_skus, $sku);
        }

        return $final_skus;
    }
}
