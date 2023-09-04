<?php

namespace App\Http\Controllers;
use Wnikk\LaravelAccessRules\Facades\AccessRules;
use Illuminate\Http\Request;

class MainPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main()
    {
        
        return view('main');
    }

}
