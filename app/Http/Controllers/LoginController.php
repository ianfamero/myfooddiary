<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Session;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest:web');
    }
  
    public function index() {
        return view('login');
    }
}
