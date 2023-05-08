<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Hash;
use Session;
use DB;

class LoginController extends Controller
{    

    public function login(){

        return view('cms.login');

    }   

    public function authenticate(Request $r){
       
        if (Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
            if (Auth::attempt(['email' => $r->email, 'password' => $r->password, 'estado' => 1])) {
                return redirect()->intended('admin')->withSuccess("¡Bienvenido de nuevo! Fecha de Acceso: ".date('d-m-Y H:i:s'));
            }else{
                return back()->withErrors([
                    'password' => '*Cuenta inactiva'
                ]);
            }
        }

        return back()->withErrors([
            'email' => '*Verifique su cuenta de correo',
            'password' => '*Verifique su contraseña'
        ]);
    }

    public function logout(){
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

   
}
