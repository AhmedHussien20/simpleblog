<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    //
    public function showRegistrationForm ()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return view('auth.login');;
    } 
}
