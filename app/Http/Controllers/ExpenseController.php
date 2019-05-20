<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\OpeningBalance;
use App\Expense;
use Carbon\Carbon;
use View;

class ExpenseController extends Controller
{

	public function index(Request $request) {
		if(empty($request->session()->get('username'))) {
			return redirect()->route('login');
		} else {
			return view('addExpenses');
		}
	}

	public function addOpeningBalance(Request $request)
	{
		$carbon = Carbon::today('Asia/Kolkata');
		$date = $carbon->toDateString();
		$addOpeningBalance = new OpeningBalance;
		$addOpeningBalance->opening_balance_amount = 1000;
		$addOpeningBalance->opening_balance_date = $date;
		$addOpeningBalance->shift_value = $request->session()->get('value');
		$addOpeningBalance->invoice_number = 0;
		if($addOpeningBalance->save()) {
			session(['shift_opening_date' => $addOpeningBalance->opening_balance_date]);
			return redirect()->route('index');
		}
	}

	public function addExpenses(Request $request) {
		$input = Input::all();
		$carbon = Carbon::today('Asia/Kolkata');
		$date = $carbon->toDateString();
		$expense = new Expense;
		$expense->expense_purpose = $input['purpose'];
		$expense->expense_amount = $input['expense_price'];
		$expense->expense_date = $date;
		$expense->shift_value = $request->session()->get('value');
		if($expense->save()){
			$openingBalance = OpeningBalance::where('shift_value','=',$request->session()->get('value'))->first();
			$openingBalance->expenses_amount += $expense->expense_amount;
			$openingBalance->opening_balance_amount -= $expense->expense_amount;
			$openingBalance->save();
		}
		return redirect()->route('addExpenses');
	}

	public function listExpenses(Request $request) {
		$listExpenses = Expense::where('shift_value','=',$request->session()->get('value'))->latest()->paginate(5);
		return View::make('listexpense')->with('listExpenses', $listExpenses);
	}
}
