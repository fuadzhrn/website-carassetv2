<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the temporary admin dashboard placeholder.
     */
    public function index(): View
    {
        return view('admin.dashboard.placeholder');
    }
}
