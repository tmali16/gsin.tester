<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index()
    {
        return view("admin.index");
    }

    public function addTesting(Request $request)
    {
        
        return view("admin.testing");
    }


    public function CreateTest(Request $request)
    {
        return view("admin.new_test");
    }
}
