<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    //
    public function main()
    {
        if( Auth::check() ){
            return redirect( route('home') );
        }
        return view('site.main');
    }
}
