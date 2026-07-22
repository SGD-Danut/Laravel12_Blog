<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome() {
        $title = 'Acasă';
        return view('admin.show-home')->with('title', $title);
    }
}
