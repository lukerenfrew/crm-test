<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;

class HomeController
{
    public function __invoke(): View
    {
        return view('admin.home');
    }
}
