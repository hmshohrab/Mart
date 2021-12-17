<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    //

    public function sessionPut(Request $request){
        $request->session()->put('name', $request->get('name'));
        echo 'putted session'.$request->session()->get('name');
    }
    public function sessionDelete(Request $request){
        $request->session()->forget('name');
        echo 'forgeted session';
    }
    public function sessionGet(Request $request){
        Session::flush();
         echo 'get session'.$request->session()->get('name');
    }
}
