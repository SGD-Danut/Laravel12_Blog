<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\File;
use LaravelLang\Publisher\Console\Update;

class UserProfileController extends Controller implements HasMiddleware
{
    /**
     * Definește middleware-urile pentru acest controller.
     */
    public static function middleware(): array
    {
        return ['auth'];
    }

    public function showEditUserProfile() {
        $user = User::findOrFail(auth()->id());
        $title = "Editare Profil Utilizator";
        return view('admin.profile.edit-user-profile')->with('user', $user)->with('title', $title);
    }

    public function updateUserProfile(UpdateUserRequest $request) {
        $request->validate(['email' => 'unique:users,email,' . auth()->id()]);

        $user = User::findOrFail(auth()->id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;

        if ($request->hasFile('photo')) {
            if ($user->photo != 'defaultUserPhoto.png') {
                File::delete('storage/admin/images/users/' . $user->photo);
            }
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('storage/admin/images/users', $photoName);

            $user->photo = $photoName;
        }

        $user->save();

        return redirect(route('admin.show-edit-user-profile'));
    }
}
