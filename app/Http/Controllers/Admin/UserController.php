<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware; // Includem interfața HasMiddleware
// use Illuminate\Routing\Controllers\Middleware; // Includem clasa Middleware

class UserController extends Controller implements HasMiddleware // Implementăm intefața în clasă
{
    /**
     * Definește middleware-urile pentru acest controller.
     */
    public static function middleware(): array
    {
        return [
            // Aplică middleware-ul 'onlyAdmin' pe toate metodele din acest controller:
            'onlyAdmin',

            // Aplică middleware-ul 'onlyAdmin' DOAR pe anumite metode (ex: showUsers și showAddUser):
            // new Middleware('onlyAdmin', only: ['showUsers', 'showAddUser']),

            // Aplică middleware-ul 'onlyAdmin' pe TOATE metodele, MAI PUȚIN pe metoda 'createUser':
            // new Middleware('onlyAdmin', except: ['createUser']),
        ];
    }

    public function showUsers() {
        $users = User::all()->sortBy('name');
        $title = "Utilizatori";
        return view('admin.users.show-users')->with('users', $users)->with('title', $title);
    }

    public function showAddUser() {
        $title = "Utilizator nou";
        return view('admin.users.show-add-user')->with('title', $title);
    }

    public function createUser(Request $request) {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();

        return redirect(route('admin.show-users'));
    }
}
