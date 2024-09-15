<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use App\Models\User;
use Illuminate\View\View;
Use Exception;
Use Log;

class LoginController extends Controller
{
    public function registro(): View
    {
        return view('login.register');
    }

    public function nuevoUsuario(Request $request)
    {
        $jsonReturn = array('success'=>false, 'error'=>[]);

        
        if(User::where('email',$request->email)->exists()){
            $jsonReturn['error'] = 'El email ya existe en nuestros registros';
        }
        else{
            $user = User::create([
                'name'   => $request->name,
                'email'  => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $jsonReturn['success'] = true;
        }
        
        
        return response()->json($jsonReturn);
    }

    public function loginView(): View
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        $jsonReturn = array('success'=>false, 'error'=>[]);

        $aUser = User::where('email',$request->email)->first();
        
        if($aUser&&Hash::check($request->password,$aUser->password)){
            Auth::loginUsingId($aUser->id);
            info("logSI");
            $jsonReturn['success'] = true;
        }
        else{
            $jsonReturn['error'] = 'Este usuario no existe';
        }
                
        return response()->json($jsonReturn);
    }

    /**
     * Log the user out of the application.
    */
    public function logout(Request $request)
    {
        Auth::logout();
    
        //$request->session()->invalidate();
    
        //$request->session()->regenerateToken();
    
        return redirect('/');
    }

}
