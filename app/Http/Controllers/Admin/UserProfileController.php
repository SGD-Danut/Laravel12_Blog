<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfilePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
            $photoName = Str::slug($request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('storage/admin/images/users', $photoName);

            $user->photo = $photoName;
        }

        $user->save();

        // return redirect(route('admin.show-edit-user-profile'));
        return redirect()->back()->with('success', 'Profilul a fost actualizat cu succes!');
    }

    public function updateUserPassword(UpdateProfilePasswordRequest $request) {
        $credentials = [
            'email' => auth()->user()->email,
            'password' => $request->old_password
        ];

        if (Auth::attempt($credentials)) {
            $newPassword = bcrypt($request->new_password);
            // $user = auth()->user();
            $user = User::findOrFail(auth()->id());
            $user->password = $newPassword;
            
            $user->save();

            return redirect()->back()->with('passwordMessage', 'Parola a fost modificată cu succes. <br> Noua parolă pentru acest cont este <strong>' . $request->new_password . '</strong>. <br> Notați noua parolă într-un loc sigur.');
        }
        
        return redirect()->back()->with('error', 'Parola nu a fost modificată cu succes, parola actuală nu este corectă!');
    }
}
