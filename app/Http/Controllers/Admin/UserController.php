<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware; // Includem interfața HasMiddleware
use Illuminate\Support\Facades\File;

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

    public function createUser(AddUserRequest $request) {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->address = $request->address;
        $user->phone = $request->phone;

        if ($request->hasFile('photo')) {
            $photoExtension = $request->file('photo')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $photoExtension;
            $request->file('photo')->move('storage/admin/images/users', $photoName);

            $user->photo = $photoName;
        }

        $confirmationUpdateMessage = "Utilizatorul " . $request->name . " a fost adăugat cu succes!";
        
        if ($request->validateEmail == 1) {
            $user->email_verified_at = now();
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului este validat.";
        } else {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " Email-ul utilizatorului nu este validat.";
        }
        
        $user->save();

        return redirect(route('admin.show-users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function showEditUser($userId) {
        $user = User::findOrFail($userId);
        $title = "Editare utilizator";
        return view('admin.users.show-edit-user')->with('user', $user)->with('title', $title);
    }

    public function updateUser(UpdateUserRequest $request, $userId) {
        $request->validate(['email' => 'unique:users,email,' . $userId]);

        $user = User::findOrFail($userId);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
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

        $finalConfirmationUpdateMessage = '';
        $confirmationUpdateMessage = 'Datele utilizatorului au fost actualizate cu succes';
        
        // Daca utilizatorul alege optiunea 'Nici-o acțiune':
        if ($request->userEmailAction == 'noAction') {
            $finalConfirmationUpdateMessage = $confirmationUpdateMessage . '.';
        }
        
        // Trimite notificare utilizatorului de confirmare email - prin email:
        if ($request->userEmailAction == 'notifyUserToConfirmEmail') {
            if ($user->email_verified_at == null) {
                $user->sendEmailVerificationNotification();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și a fost trimisă o notificare utilizatorului prin email pentru confirmare a email-ului.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . ", dar nu s-a trimis o notificare utilizatorului prin email pentru confirmare a email-ului deoarece adresa de email este deja validată.";
            }
        }
        
        // Validare email:
        if ($request->userEmailAction == 'validateEmail') {
            if ($user->email_verified_at == null) {
                $user->email_verified_at = now();
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost validat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " dar email-ul nu a fost validat cu succes deoarece este deja validat.";   
            }
        }
        
        // Invalidare email:
        if ($request->userEmailAction == 'invalidateEmail') {
            if ($user->email_verified_at != null) {
                $user->email_verified_at = null;
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul a fost invalidat cu succes.";
            } else {
                $finalConfirmationUpdateMessage = $confirmationUpdateMessage . " și email-ul nu a fost invalidat cu succes deoarece este deja invalidat.";
            }
        }

        $user->save();

        return redirect(route('admin.show-users'))->with('success', $finalConfirmationUpdateMessage);
    }

    public function deleteUser(Request $request, $userId) {
        $user = User::findOrFail($userId);

        if ($user->role == 'admin') {
            return redirect(route('admin.show-users'));
        }

        if ($user->photo != 'defaultUserPhoto.png') {
            File::delete('storage/admin/images/users/' . $user->photo);
        }

        $user->delete();

        return redirect(route('admin.show-users'));
    } 
}
