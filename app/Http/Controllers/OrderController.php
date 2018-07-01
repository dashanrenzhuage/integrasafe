<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Orders;
use Auth;
use Request;

/* Modals */

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('domain');
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = Auth::user();

        if (Auth::check()) {

            $orders = Orders::where('user_id', $id)->get();

            return view('pcb.profile.orders', [
                'orders' => $orders,
                'user' => $user
            ]);
        }

        // else return User back to homepage
        return view('/');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        return redirect('/user/' . Auth::user()->id . "/orders");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

}
