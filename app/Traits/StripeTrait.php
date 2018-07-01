<?php
declare(strict_types=1);

namespace App\Traits;

use App\BillingAddress;
use App\Customers;
use App\ProductSkus;
use App\ProductSubscriptions;
use App\Users;
use Exception;
use Laravel\Cashier\Cashier;
use Stripe\Stripe;

/**
 * Trait StripeTrait
 * @package App\Traits
 */
trait StripeTrait
{
    // Column Names
    private $emailColumn = 'email';

    // See this link for using Cashier and Stripe
    // https://laravel.com/docs/5.5/billing

    /**
     * Trait constructor.
     */
    public function __construct()
    {
        Cashier::useCurrency('usd', '$');
        Stripe::setApiKey("sk_test_bGM19IIR5U9NVPrgRX6vmOxS");
    }

    /**
     * Charge a User's Card
     * @param int $amount
     * @param \Stripe\Customer $customer
     */
    public function chargeCard(int $amount, \Stripe\Customer $customer)
    {
        // Charge the user's card:
        $charge = \Stripe\Charge::create([
            "amount" => $amount,
            "currency" => "usd",
            "description" => "Example charge",
            "receipt_email" => $customer[$this->emailColumn],
            "customer" => $customer['id']
        ]);

        return $charge;
    }

    /**
     * Charge a User's Card for an Order
     * @param array $order
     * @param \Stripe\Customer $customer
     */
    public function chargeCardOrder(array $order_ids, \Stripe\Customer $customer)
    {
        // Charge the user's card:
        $order = \Stripe\Order::retrieve($order_ids[1]);
        $order->pay([
            "customer" => $customer
        ]);

        return $order;
    }

    /**
     * Update an existing Customer's Stripe ID, Email address, or associate a User account with a Stripe Customer
     * @param String $email
     * @param String $source
     * @return \Stripe\Customer
     */
    public function updateCustomer(String $email, String $source)
    {
        $user_token = Customers::where($this->emailColumn, $email)->value('stripe_id');
        $customer = \Stripe\Customer::retrieve($user_token);
        $customer->sources->create(["source" => $source]);
        $customer->save();

        // See if Customer has created an IntegraSafe account
        try {
            $user = Users::where($this->emailColumn, $email)->get();
            $user_id = $user->id;
        } catch (Exception $except) {
            $user_id = null;
        }

        // Update Customer info in database
        Customers::update([
            'user_id' => $user_id,
            'stripe_id' => $customer['id']
        ])->where($this->emailColumn, $email);

        return $customer;
    }

    /**
     * Retrieves a Stripe Customer (API) if they exist,
     * if they do not, then it will Create a Stripe Customer
     * @param String $email
     * @return bool|\Stripe\Customer
     */
    public function getCustomer(String $email, String $stripeToken)
    {
        // See if the User has a payment account in our Database
        $user_token = Customers::where($this->emailColumn, $email)->value('stripe_id');

        if ($user_token === null) {
            // Not a Customer yet, create one
            return $this->createCustomer($email, $stripeToken);
        } else {
            // Get Customer's token and return their instance from Stripe
            return \Stripe\Customer::retrieve($user_token);
        }
    }

    /**
     * Creates a Stripe Customer (API) and replicates the data in our own database
     * @param String $email
     * @param String $source
     * @return \Stripe\Customer
     */
    public function createCustomer(String $email, String $source)
    {
        // Create Stripe User
        $customer = \Stripe\Customer::create([
            "email" => $email,
            "source" => $source,
        ]);
        $customer->save();
        $customer_id = $customer['id'];

        // See if Customer has created an IntegraSafe account
        try {
            $user_id = Users::where($this->emailColumn, $email)->value('id');
        } catch (Exception $except) {
            $user_id = null;
        }

        // Save Customer in database
        Customers::create([
            'user_id' => $user_id,
            $this->emailColumn => $email,
            'stripe_id' => $customer_id
        ]);

        return $customer;
    }

    /**
     * Alternative method for retrieving a Customer from Stripe
     * using their Stripe Customer ID instead of their email address and Stripe Card Token
     * @param $customer_id
     * @return \Stripe\Customer
     */
    public function getCustomerDetails($customer_id)
    {
        return \Stripe\Customer::retrieve($customer_id);
    }

    /**
     * Checks the database to see if a Product Subscription plan is associated with a given Product SKU
     * @param String $product_sku
     * @return bool|\Stripe\Plan
     */
    public function checkForSubscription(String $product_sku)
    {
        // Kep needs to be set here in order to call this method statically from another class, controller, or trait
        Stripe::setApiKey("sk_test_bGM19IIR5U9NVPrgRX6vmOxS");

        // Get SKU's ID
        $sku_id = (ProductSkus::select('id')
            ->where('product_sku', $product_sku)
            ->get())[0];

        try {
            // Get the plan ID for a SKU (if exists)
            $plan_id = (ProductSubscriptions::select('stripe_plan_id'))
                ->where('product_sku', $sku_id['id'])
                ->get()[0];

            return \Stripe\Plan::retrieve($plan_id['stripe_plan_id']);
        } catch (\Exception $except) {
            // If there is no Stripe Subscription Plan associated with a Product, return false
            return false;
        }
    }

    /**
     * Updates an existing Customer's billing information in our database
     * @param String $email
     * @param \Stripe\Customer $customer
     * @param String $name
     * @param String $address
     * @param String $city
     * @param String $state
     * @param String $country
     * @param String $zipcode
     */
    public function updateBilling(String $email, \Stripe\Customer $customer, String $name, String $address, String $city,
                                  String $state, String $country, String $zipcode)
    {

        // Get the user (if exists) based on Customer ID
        $customer_id = (Customers::select('id')->where('stripe_id', $customer['id'])->get())[0]['id'];
        $user_billing = BillingAddress::select('id')->where('customer_id', $customer_id)->get();

        if ((string)$user_billing !== "[]") {
            // update Billing information
            $bill = BillingAddress::where('customer_id', $customer_id)
                ->where($this->emailColumn, $email)
                ->where('name', $name)
                ->update([
                    'customer_id' => $customer_id,
                    $this->emailColumn => $email,
                    'name' => $name,
                    'street_address' => $address,
                    'city/town' => $city,
                    'state' => $state,
                    'country' => $country,
                    'zip_code' => $zipcode
                ]);
        } else {
            // new Billing information row
            BillingAddress::insert([
                'customer_id' => $customer_id,
                $this->emailColumn => $email,
                'name' => $name,
                'street_address' => $address,
                'city/town' => $city,
                'state' => $state,
                'country' => $country,
                'zip_code' => $zipcode
            ]);
        }

        // Return ID of database row
        return (BillingAddress::select('id')
            ->where('customer_id', $customer_id)
            ->where($this->emailColumn, $email)
            ->where('name', $name)
            ->get())[0]['id'];
    }

}
