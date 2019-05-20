<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{
    public function index(Request $request) {
        if(empty($request->session()->get('username'))) {
            return view('login');
        } else {
            if($request->session()->get('username') == "Admin") {
                return view('admindashboard');
            } else {
                return redirect()->route('index');
            }
        }
    }

    public function login() {
            $input = Input::all();
            if($input['username'] == 'morning' && $input['password'] == 'admin@123') {
                session(['username' => 'Morning Shift', 'value' => '1']);
                return redirect()->route('index');
            } elseif ($input['username'] == 'evening' && $input['password'] == 'admin@123') {
                session(['username' => 'Evening Shift', 'value' => '2']);
                return redirect()->route('index');
            } elseif ($input['username'] == 'admin' && $input['password'] == 'admin') {
                session(['user' => 'Admin', 'value' => '0']);
                return redirect()->route('admindashboard');
            }

            return redirect()->route('login');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
