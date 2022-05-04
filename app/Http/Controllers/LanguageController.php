<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Get locale or Set locale
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        if (!Session::has('locale')) {
            \Session::put('locale', $request->get('locale'));
        } else {
            \Session::put('locale', $request->get('locale'));
        }

        return redirect()->back();
    }
}
