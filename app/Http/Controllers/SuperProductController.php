<?php
declare(strict_types=1);

namespace App\Http\Controllers;

// Traits
use App\Classes\CookieMonster;
use App\ProductInventory;
use App\ProductSkus;
use App\StripeProducts;
use App\Traits\StripeTrait;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

// Classes

/**
 * Extends Controller
 *
 * Uses StripeTrait
 *
 * Class SuperProductController
 * @package App\Http\Controllers
 */
class SuperProductController extends Controller
{
    use StripeTrait;

    public function __construct(CookieJar $cookiejar)
    {
        \Stripe\Stripe::setApiKey("sk_test_bGM19IIR5U9NVPrgRX6vmOxS");

        // Set the CookieJar (which holds methods)
        $this->cookies = new CookieMonster($cookiejar);
        $this->cookiejar = $cookiejar;
    }

    public function createIndex()
    {
        return view('integrasafe.create', [
            'cart' => $this->cookies->checkCookieCart()
        ]);
    }

    /**
     * @param Request $request
     */
    public function createProduct(Request $request)
    {
        // First, create Product on Stripe
        $stripe_product = \Stripe\Product::create([
            "name" => $request->name,
            "caption" => $request->caption,
            "description" => $request->description
        ]);

        // Then, insert into our own Database using Stripe's Product ID
        StripeProducts::insert([
            "stripe_product_id" => $stripe_product['id'],
            "name" => $request->name,
            "caption" => $request->caption,
            "description" => $request->description,
            "status" => "active",
            "shippable" => "yes",
            "purchasable_url" => "https://dev.integrasafe.net",
        ]);
        $product_id = StripeProducts::select('id')
            ->where("stripe_product_id", $stripe_product['id'])->get();

        // Next, (FOR TESTING PURPOSES) temporarily create SKU
        $price = $request->price * 100;
        $stripe_sku = \Stripe\SKU::create([
            "product" => $stripe_product['id'],
            "price" => $price,
            "currency" => "usd",
            "inventory" => [
                "type" => "finite",
                "quantity" => $request->inventory
            ]
        ]);

        ProductSkus::insert([
            'product_id' => $product_id[0]['id'],
            'product_sku' => $stripe_sku['id'],
            'price' => $price,
            'width' => "1",
            'length' => "1",
            'height' => "1",
            'weight' => "1",
        ]);
        $sku_id = ProductSkus::select('id')
            ->where("product_sku", $stripe_sku['id'])->get();

        // Lastly, update Inventory for SKU
        ProductInventory::insert([
            'product_sku' => $sku_id[0]['id'],
            'inventory' => $request->inventory
        ]);
    }

}
