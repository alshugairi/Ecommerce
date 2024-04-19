<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        return view('modules.dashboard.index');
    }
}
