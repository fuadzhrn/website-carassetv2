<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home.index');
    }

    public function business()
    {
        return view('pages.business.index');
    }

    public function partnership()
    {
        return view('pages.partnership.index');
    }

    public function simulation()
    {
        return view('pages.simulation.index');
    }

    public function aboutContact()
    {
        return view('pages.about-contact.index');
    }
}
