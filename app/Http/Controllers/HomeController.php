<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        app()->setLocale(session('locale', 'ar'));
        $products = Product::paginate(16);
        return view('home', get_defined_vars());
    }
}
