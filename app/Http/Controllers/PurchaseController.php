<?php
declare(strict_types=1);

namespace App\Http\Controllers;

// Traits
use App\Classes\CookieMonster;
use App\Customers;
use App\Orders;
use App\ProductSkus;
use App\Purchases;
use App\Traits\ProductsTrait;
use App\Traits\StripeTrait;
use App\Traits\UserTrait;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

// Classes

/**
 * Extends Controller
 *
 * Uses StripeTrait, UserTrait, ProductsTrait
 *
 * Class PurchaseController
 * @package App\Http\Controllers
 */
class PurchaseController extends Controller
{
    use StripeTrait;
    use UserTrait;
    use ProductsTrait;

    // STRIPE
    public $sentryClient;
    private $name;
    private $email;
    private $card;
    private $customer;
    // DISCOUNT
    private $total = 0;
    // BILLING
    private $discount;
    private $billingAddress;
    private $billingCity;
    private $billingState;
    private $billingCountry;
    // SHIPPING
    private $billingZipCode;
    private $shippingAddress;
    private $shippingCity;
    private $shippingState;
    private $shippingCountry;
    private $shippingZipCode;
    // PRODUCTS
    private $lead_time;
    private $productSkus = [];

    // COLUMN NAMES
    private $tax = 0.07;
    private $productSkuColumn = 'product_sku';
    private $billingAddressColumn = 'billing_address';

    // Used to determine what part of the payment_process.blade is active and colored
    private $shippingAddressColumn = 'shipping_address';
    private $active_process = "mdc-tab--active mdc-ripple-upgraded--background-focused";

    // Cart
    private $previous_process = "previous-active";
    private $cookiejar;

    // Sentry
    private $cookies;

    /**
     * PurchaseController constructor.
     * @param CookieJar $cookiejar
     */
    public function __construct(CookieJar $cookiejar)
    {
        // Set Stripe API key
        \Stripe\Stripe::setApiKey("sk_test_bGM19IIR5U9NVPrgRX6vmOxS");

        // Set the CookieJar (which holds methods)
        $this->cookies = new CookieMonster($cookiejar);
        $this->cookiejar = $cookiejar;
    }

    /**
     * This function get the entire form submitted during the Payment Section,
     * (including the Customer's information, the products they selected, the shipping.billing info, etc.)
     * And Creates a Stripe Order for them to then review.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function review(Request $request)
    {
//        echo($request);
        app('sentry')->breadcrumbs->record([
            'user' => ['name' => $this->name, 'email' => $this->email],
            'message' => 'A Customer has submitted the Purchase Form',
            'logger' => 'info',
        ]);

//        echo $request;
        // STRIPE
        $this->name = $request->cardholderName;
        $this->email = $request->cardholderEmail;
        $this->card = $request->stripeToken;
        $this->customer = $this->getCustomer($this->email, $this->card);
        // DISCOUNT
        try {
            $this->discount = $request->discount;
        } catch (\Exception $except) {
            // no discount was applied
            $this->discount = 1;
        }
        // BILLING
        $this->billingAddress = $request->billingAddress;
        $this->billingCity = $request->billingCity;
        $this->billingState = $request->billingState;
        $this->billingCountry = $request->billingCountry;
        $this->billingZipCode = $request->billingZipCode;
        // SHIPPING
        try {
            // If the User has selected that the Billing and shipping address are the same,
            // then set the shipping information to the same as the billing information
            if (isset($request->same_as_billing)) {
                $this->shippingAddress = $request->billingAddress;
                $this->shippingCity = $request->billingCity;
                $this->shippingState = $request->billingState;
                $this->shippingCountry = $request->billingCountry;
                $this->shippingZipCode = $request->billingZipCode;
            }
        } catch (\Exception $except) {
            // Otherwise, the Shipping information is different from Billing
            $this->shippingAddress = $request->shippingAddress;
            $this->shippingCity = $request->shippingCity;
            $this->shippingState = $request->shippingState;
            $this->shippingCountry = $request->shippingCountry;
            $this->shippingZipCode = $request->shippingZipCode;
        }

        // Shipping Speed
        $this->lead_time = $request->shipping_group;

        // PRODUCTS (app\Traits\StripeTrait.php)
        $this->productSkus = $this->getSelectedSkus($request);

        // Update Sentry on the SKUs the Customer has selected to purchase
        app('sentry')->breadcrumbs->record([
            'user' => ['name' => $this->name, 'email' => $this->email],
            'message' => 'The Customer has selected the following SKUs: ' . json_encode($this->productSkus),
            'extra' => $this->productSkus,
            'logger' => 'info',
        ]);

        // Update/Create the Customer's Billing and Shipping information in Database
        $address_ids = $this->updateAddresses();

        // Calculate the total amount (in cents) the Customer has purchased, with tax.
        $items = $this->calculatePrice();

        // Update Sentry on Customer's total price
        app('sentry')->breadcrumbs->record([
            'user' => ['name' => $this->name, 'email' => $this->email],
            'message' => 'The Customer has a total cart value of $' . $this->total . " (cents)",
            'logger' => 'info',
        ]);

        // Create Order (but don't pay for it yet)
        $order_ids = $this->createOrder($address_ids, $items);

        // Squish the shipping and billing addresses into an array of two objects
        $addresses = $this->compactAddresses();

        // Get the SKUs from the session data for diplaying
        $cart_skus = $this->cookies->getCookie("user_cart");
        $selected_skus = $this->getSkuInformation($cart_skus, true, true);

        // direct to review page with their previously submitted data
        return view('integrasafe.purchase.review', [
            'payment_process' => [
                'select' => $this->previous_process,
                'purchase' => $this->previous_process,
                'confirm' => $this->active_process],
            'cart' => $this->cookies->checkCookieCart(),
            'customer' => $this->getCustomerDetails($this->customer['id']),
            'product_total' => $this->calculateSkuPrice($this->cookies),
            'tax' => $this->total * $this->tax,
            'total' => $this->total,
            'shipping_price' => $this->calculateShipping($this->lead_time),
            'billing_address' => $addresses[0],
            'shipping_address' => $addresses[1],
            'order_id' => $order_ids,
            'skus' => $selected_skus,
        ]);
    }

    /**
     * Updates/Creates the Customer's Billing and Shipping address associated  with their most recent order
     * @return array
     */
    private function updateAddresses()
    {
        $address_ids = [];
        // Update Billing Information (app\Traits\StripeTrait.php)
        $billing_id = $this->updateBilling($this->email, $this->customer, $this->name, $this->billingAddress,
            $this->billingCity, $this->billingState, $this->billingCountry, $this->billingZipCode);
        // Update Shipping Information (app\Traits\UserTrait.php)
        $shipping_id = $this->updateShipping($this->email, $this->name, $this->shippingAddress, $this->shippingCity,
            $this->shippingState, $this->shippingCountry, $this->shippingZipCode);

        // Add database row IDs to array
        array_push($address_ids, $billing_id);
        array_push($address_ids, $shipping_id);

        // Return array of address IDs
        return $address_ids;
    }

    /**
     * Adds the price (in cents) of all the Products the Customer has selected to purchase, with or without a Discount
     * @return array $items
     */
    private function calculatePrice()
    {
        $items = [];

        // Loop through all the products that were selected
        for ($counter = 0; $counter < count($this->productSkus); $counter++) {
            // Add item for creating Stripe Order
            $item = [
                "type" => "sku",
                "parent" => $this->productSkus[$counter][$this->productSkuColumn],
                "amount" => $this->productSkus[$counter]['price'],
                "quantity" => $this->cookies->getCartItemQuantity($this->productSkus[$counter]['product_sku']),
            ];
            array_push($items, $item);

        }
        // Update Total price for Products
        $this->total = $this->calculateSkuPrice($this->cookies);

        // Factor in shipping
        $shipping = $this->calculateShipping($this->lead_time);

        // Factor in tax
        $tax = $this->total * $this->tax;

        // Apply discount (if applicable)
        //todo

        // Add in shipping, tax, and discounts
        $this->total = $this->total + $shipping + $tax;

        // Return list of product items to be used in creating a Stripe Order
        return $items;
    }

    /**
     * Create an Order row(s) in Payment Database
     * If the Customer already has an open Order and it's different, ask if they want to cancel it
     * @param array $address_ids
     * @param array $items
     * @return array
     */
    private function createOrder(array $address_ids, array $items)
    {
        // First check to see if the Customer hasn't already created an Order
        $previous_order = $this->checkForOrder($address_ids);
        if ($previous_order !== []) {
            // If they have a previous Order, return those IDs rather than creating a new one
            $stripe_order = \Stripe\Order::retrieve($previous_order[1]);
            if ($stripe_order['items'] === $items) {
                return $previous_order;
            } else {
                //ask the Customer if they want to cancel their previous Order
                //todo
            }
        }

        // ----- Stripe Database
        $stripe_order = \Stripe\Order::create([
            "items" => $items,
            "currency" => "usd",
            "coupon" => $this->discount,
            "shipping" => [
                "name" => $this->name,
                "address" => [
                    "line1" => $this->shippingAddress,
                    "city" => $this->shippingCity,
                    "state" => $this->shippingState,
                    "country" => $this->shippingCountry,
                    "postal_code" => $this->shippingZipCode
                ]
            ],
            "email" => $this->email
        ]);

        // ----- Our Database
        // Create first/main Order
        Orders::insert([
            'stripe_order_id' => $stripe_order['id'],
            'status' => 'CREATED',
            $this->productSkuColumn => (ProductSkus::select('id')
                ->where($this->productSkuColumn, $this->productSkus[0][$this->productSkuColumn])
                ->get())[0]['id'],
            $this->billingAddressColumn => $address_ids[0],
            $this->shippingAddressColumn => $address_ids[1],
            'discount' => $this->discount,
            'price_after_discount' => $this->total,
            'shipping_speed' => $this->lead_time . " days",
            'order_chain' => '0'
        ]);

        $main_order_id = (Orders::select('id')
            ->where('stripe_order_id', $stripe_order['id'])
            ->where($this->billingAddressColumn, $address_ids[0])
            ->where($this->shippingAddressColumn, $address_ids[1])
            ->orderBy('id', 'desc')
            ->take(1)
            ->get())[0]['id'];

        // Loop through the remaining (if any) products that were purchased
        for ($counter = 1; $counter < count($this->productSkus); $counter++) {
            // Create entry for each Product purchased, with a reference to the main Order entry
            Orders::insert([
                'stripe_order_id' => $stripe_order['id'],
                'status' => 'CREATED',
                $this->productSkuColumn => (ProductSkus::select('id')
                    ->where($this->productSkuColumn, $this->productSkus[$counter][$this->productSkuColumn])
                    ->get())[0]['id'],
                $this->billingAddressColumn => $address_ids[0],
                $this->shippingAddressColumn => $address_ids[1],
                'discount' => $this->discount,
                'price_after_discount' => $this->total,
                'shipping_speed' => $this->lead_time . " days",
                'order_chain' => $main_order_id
            ]);
        }

        return [$main_order_id, $stripe_order['id']];
    }

    /**
     * Check to see if the Customer has an open Order that was created and either
     * A. not paid for or,
     * B. not canceled yet
     * @param array $address_ids
     * @return \___PHPSTORM_HELPERS\static|mixed
     */
    public function checkForOrder(array $address_ids)
    {
        // Get the Main Order ID
        $order_ids = (Orders::select('id', 'stripe_order_id')
            ->where('billing_address', $address_ids[0])
            ->where('shipping_address', $address_ids[1])
            ->where('status', 'CREATED')
            ->where('order_chain', '0')
            ->orderBy('id', 'desc')
            ->get())[0];

        try {
            // Try to return the IDs, if they are no IDs found this will throw an error
            return [$order_ids['id'], $order_ids['stripe_order_id']];
        } catch (\Exception $exception) {
            // and be caught here to return an empty array
            return [];
        }
    }

    /**
     * Compact User Address into Objects
     * @return array
     */
    public function compactAddresses()
    {
        $billing = new \stdClass();
        $shipping = new \stdClass();

        // Build an Object for Billing information
        $billing->address = $this->billingAddress;
        $billing->city = $this->billingCity;
        $billing->state = $this->billingState;
        $billing->country = $this->billingCountry;
        $billing->zipcode = $this->billingZipCode;

        // Build an Object for Shipping information
        $shipping->address = $this->shippingAddress;
        $shipping->city = $this->shippingCity;
        $shipping->state = $this->shippingState;
        $shipping->country = $this->shippingCountry;
        $shipping->zipcode = $this->shippingZipCode;

        return [$billing, $shipping];
    }

    /**
     * Cancel a previously unpaid Order
     * @param array $order_ids
     */
    public function cancelOrder(array $order_ids)
    {
        // Update Stripe
        $order = \Stripe\Order::retrieve($order_ids[1]);
        $order->metadata["status"] = "canceled";
        $order->save();

        // Update Order row
        Orders::where('id', $order_ids[0])
            ->update(['status' => "CANCELED"]);
    }

    /**
     * After the Cutsomer has reviewed their Order details,
     * this function will complete the Checkout and Payment Process
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchase(Request $request)
    {
        $stripe_order_id = $request->stripe_order_id;
        $order_id = $request->order_id;
        $this->customer = $this->getCustomer($request->email, "");

        // Create Purchase
        $this->createPurchase([$order_id, $stripe_order_id]);

        // Update Order row
        Orders::where('stripe_order_id', $stripe_order_id)
            ->where('status', 'CREATED')
            ->orderBy('id', 'desc')
            ->take(1)
            ->update(['status' => "PURCHASED"]);

        // Update Product SKU's inventory (app\Traits\ProductsTrait.php)
        foreach ($this->productSkus as $product) {
            $this->updateSkuInventory($product[$this->productSkuColumn]);
        }

        // Update Sentry on Customer's total price
        app('sentry')->breadcrumbs->record([
            'message' => "The SKU's the Customer has purchased have been subtracted from our Inventory",
            'logger' => 'info',
        ]);

        // Reset the Cart cookie back to empty
        $this->cookies->deleteCookie("user_cart");

        return view('integrasafe.purchase.success', [
            'payment_process' => [
                'select' => $this->previous_process,
                'purchase' => $this->previous_process,
                'confirm' => $this->active_process],
            'cart' => $this->cookies->checkCookieCart()
        ]);
    }

    /**
     * Using the Stripe Order ID and the Database Order ID,
     * this function will charge the Customer's Stripe account for the Order they have created
     * @param array $order_ids
     */
    private function createPurchase(array $order_ids)
    {
        // Charge Card for Order and get transaction ID from stripe (app\Traits\StripeTrait.php)
        $transaction_id = $this->chargeCardOrder($order_ids, $this->customer);

        // get Customer's database ID
        $customer_id = (Customers::select('id')
            ->where('stripe_id', $this->customer['id'])
            ->get())[0]['id'];

        Purchases::insert([
            'order_id' => $order_ids[0],
            'customer_id' => $customer_id,
            'transaction_id' => $transaction_id['id']
        ]);

        // Update Sentry on Customer's Transaction ID
        app('sentry')->breadcrumbs->record([
            'user' => ['email' => $this->email],
            'message' => 'The Customer has made a successful purchase. The Transaction ID is ' . $transaction_id['id'],
            'logger' => 'info',
        ]);
    }
}
