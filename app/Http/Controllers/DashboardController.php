<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{

    /**
     * @return View
     */
    public function index(): View
    {
        $productsCount = Product::count();
        $usersCount = User::count();
        $categoriesCount = Category::count();
        $languagesCount = Language::count();
        return view('modules.dashboard.index', get_defined_vars());
    }
}
