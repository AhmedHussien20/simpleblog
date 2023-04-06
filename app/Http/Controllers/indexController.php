<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class indexController extends Controller
{
   public function showDashBoard(){
      $userName=session()->get('login');
      return view('index',compact('userName'));
   }
   
   public function logout()
   {
      session()->flush();
      return redirect('/login');
   }
}
