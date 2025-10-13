<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    /**
     * Display the user's profile Dashboard.
     */
    public function faq(Request $request)
    {
        return view('pages.faq');
    }
}
