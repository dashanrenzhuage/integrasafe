<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Classes\CookieMonster;
use App\Classes\Validation;
use App\Newsletter;
use App\ProductSkus;
use App\Traits\ProductsTrait;
use App\Traits\StripeTrait;
use Exception;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;

/**
 * Extends Controller
 *
 * Uses Request
 *
 * Class IntegrasafeController
 * @package App\Http\Controllers
 */
class IntegrasafeController extends Controller
{
    use ProductsTrait;
    use StripeTrait;

    private $cookiejar;
    private $cookies;
    // Used to determine what part of the payment_process.blade is active and colored
    private $active_process = "mdc-tab--active mdc-ripple-upgraded--background-focused";
    private $previous_process = "previous-active";

    // Sentry
    public $sentryClient;

    /**
     * IntegrasafeController constructor.
     * @param CookieJar $cookiejar
     */
    public function __construct(CookieJar $cookiejar)
    {
        // Set the CookieJar (which holds methods)
        $this->cookies = new CookieMonster($cookiejar);
        $this->cookiejar = $cookiejar;
    }

    /**
     * Route the current User to view all our Products associated with the Integrasafe Company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function purchaseIndex()
    {
        // Update Sentry on Customer's total price
        app('sentry')->breadcrumbs->record([
            'message' => 'The User has arrived at the Purchase Index Page to begin the Payment Process',
            'logger' => 'info',
        ]);

        // TESTING PURPOSES
//        $this->cookies->deleteCookie("user_cart");

        // Get the SKU, Price, Name, and Stock of all Products to display to the User
        $all_products = ProductSkus::select('id', 'product_sku', 'product_id', 'price')->get();
        $product_skus = $this->getSkuInformation($all_products);

        return view('integrasafe.purchase.index', [
            'product_skus' => $product_skus,
            'payment_process' => ['select' => $this->active_process, 'purchase' => "", 'confirm' => "disabled"],
            'cart' => $this->cookies->checkCookieCart(),
        ]);
    }

    /**
     * Route the current User to the Payment Section of the Payment Process (i.e. the Checkout Cart)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentIndex()
    {
        // Update Sentry on Customer's total price
        app('sentry')->breadcrumbs->record([
            'message' => 'The User has arrived at the Payment Page to end the Payment Process and purchase their selected products',
            'logger' => 'info',
        ]);

        $total = $this->calculateSkuPrice($this->cookies);

        // Get the SKUs from the session data
        $cart_skus = $this->cookies->getCookie("user_cart");
        $selected_skus = $this->getSkuInformation($cart_skus, true, true);

        // Get related products / accessories based upon the selected SKUs
        // add later...

        // Calculate sales tax
        $tax = $total * 0.07;
        // Add all totals together (product total, tax, and shipping)
        $total = $total + $tax + 15;

        // display the Payment form with the selected SKUs and all relevant accessories that can also be purchased
        return view('integrasafe.purchase.payment', [
            'skus' => $selected_skus,
            'payment_process' => [
                'select' => $this->previous_process,
                'purchase' => $this->active_process,
                'confirm' => ""],
            'total' => $total,
            'tax' => $tax,
            'cart' => $this->cookies->checkCookieCart()
        ]);
    }

    /**
     * Temporary Route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function temporary()
    {
        return view('integrasafe.temporary');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function careers()
    {
        return view('integrasafe.careers');
    }

    /**
     * Insert a User's email address into the newsletter table in order to be sent news updates
     * @param Request $request
     * @return string
     */
    public function newsletter(Request $request)
    {
        try {
            // Get user's email address
            $request_contents = $request->all();
            $email = $request_contents['email'];

            if ($request_contents['beta'] === "on") {
                $beta_tester = "yes";

                $check = Newsletter::where('email', $email)
                    ->where('beta_tester', '=', $beta_tester)
                    ->count();

                if ($check !== 0) {
                    return "Email address is already subscribed to be a Beta Tester!";
                }
            } else {
                $beta_tester = "no";
            }

            if ($request_contents['newsletter'] === "on") {
                $newsletter = "yes";

                $check = Newsletter::where('email', $email)
                    ->where('newsletter', '=', $newsletter)
                    ->count();

                if ($check !== 0) {
                    return "Email address is already subscribed to our newsletter!";
                }

            } else {
                $newsletter = "no";
            }

            if ($request_contents['newsletter'] !== "on" && $request_contents['beta'] !== "on") {
                return "You have not picked anything to subscribe to!";
            }

            // Update Sentry on Customer's total price
            app('sentry')->breadcrumbs->record([
                'user' => $email,
                'message' => 'This User has signed up to our newsletter form',
                'logger' => 'info',
            ]);

            // Validate the User's email address
            $validation = new Validation();
            $valid = $validation->email(50, 'Email', $email, false);
            if ($valid !== true) {
                return "Please enter a valid email address";
            }

            // Check to see if User isn't already subscribed to our newsletter
            $check = Newsletter::where('email', $email)->count();

            if ($check !== 0) {
                // Store the User's email
                Newsletter::where('email', $email)
                    ->update([
                        'beta_tester' => $beta_tester,
                        'newsletter' => $newsletter
                    ]);
            } else {
                // Store the User's email
                Newsletter::insert([
                    'email' => $email,
                    'beta_tester' => $beta_tester,
                    'newsletter' => $newsletter
                ]);
            }

            // Show success message
            return "Thank you for signing up, we will be in touch soon!";
        } catch (Exception $except) {
            return "We're sorry, we're unable to process your request at this moment. Please try again";
        }
    }
}
