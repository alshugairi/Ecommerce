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
        $products = Product::paginate();
        return view('home');
    }
}
