<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function index(Request $request) {
		if($request->session()->get('user') == "Admin") {
			return view('admindashboard');
		} else {
			return redirect()->route('login');
		}
	}

	public function getShift(Request $request, $shift) {
		 session(['shift' => $shift, 'value' => $shift == "Morning Shift" ? 1 : 2, 'user' => 'Admin']);
		return redirect()->route('admindashboard');
	}
}
