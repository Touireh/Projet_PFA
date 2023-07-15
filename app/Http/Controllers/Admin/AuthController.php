<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');

    }
    public function postLogin(Request $request){
        
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'

        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials,$request->has('remember'))) {
            $user = Auth::user();

            if ($user->is_admin) {
                // Redirection pour l'administrateur
                return redirect('/admin/dashboard')->with(
                    'sucess' , 'Login Successfull.');
            } else {
                // Redirection pour l'utilisateur normal
                return redirect('/user/dashboard');
            }
        } else {
            // L'authentification a échoué
            return redirect()->back()->with(
                'error' , 'Invalid credentials.');
        }
    
    }
}
