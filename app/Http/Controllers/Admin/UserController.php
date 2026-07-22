<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showUsers() {
        $users = User::all()->sortBy('name');
        $title = "Utilizatori";
        return view('admin.users.show-users')->with('users', $users)->with('title', $title);
    }
}
