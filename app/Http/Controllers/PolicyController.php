<?php
declare(strict_types=1);

namespace App\Http\Controllers;

/**
 * Class PolicyController
 * @package App\Http\Controllers
 */
class PolicyController extends Controller
{
    /**
     * Display the Privacy Policy view.
     *
     * @return \Illuminate\Contracts\View\Factory|
     * \Illuminate\View\View
     */
    public function privacy()
    {
        return view('documents.policy.privacy');
    }

    /**
     * Display the terms of service view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function termsOfService()
    {
        return view('documents.policy.terms_of_service');
    }
}
