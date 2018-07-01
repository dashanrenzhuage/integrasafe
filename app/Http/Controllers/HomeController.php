<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Alerts;
use App\Classes\CookieMonster;
use App\Classes\DataObject;
use App\Classes\DisplayGroups;
use App\Classes\TimeChecks;
use App\Devices;
use App\ExpiredInventoryAlerts;
use App\Inventories;
use App\Machines;
use App\Products;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;


/**
 * Class Home
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    // Sentry
    public $sentryClient;

    public $dataObject = null;
    public $request = null;
    public $activeFlow = null;
    public $cookies = null;

    // String Literals
    public $account_id = 'account_id';
    public $insert = 'insert';
    public $version = 'version';
    public $complete = 'complete';
    public $isMobile = 'isMobile';
    public $isTouch = 'isTouch';
    public $status = 'status';

    /**
     * Home constructor.
     * @param Request $request
     * @param CookieJar $cookiejar
     */
    public function __construct(CookieJar $cookiejar, Request $request)
    {
        // Set the CookieJar (which holds the methods)
        $this->cookies = new CookieMonster($cookiejar);

        app('sentry')->breadcrumbs->record([
            'message' => 'A user has arrived at the website homepage',
            'logger' => 'info',
        ]);
    }

    /**
     * Show the PCB application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function integrasafeIndex()
    {
        app('sentry')->breadcrumbs->record([
            'message' => 'The User has arrived at the Integrasafe Index Page',
            'logger' => 'info',
        ]);

        return view('integrasafe.index', [
            'cart' => $this->cookies->checkCookieCart()
        ]);
    }
}
