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
}
