<?php

namespace App\Http\Controllers\Administration;

use App\{Http\Controllers\Controller};
use Illuminate\{Http\RedirectResponse, Support\Facades\Artisan};

class SystemController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function clearCache(): RedirectResponse
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return back();
    }
}
