<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/clear', function() {
	$exitCode = Artisan::call('config:cache');
	return "success";
});

Route::get('/', ['as'=>'/','uses'=>'LoginController@index']);

Route::get('/login', ['as'=>'/login','uses'=>'LoginController@index']);

Route::post('/login', ['as'=>'login','uses'=>'LoginController@login']);

Route::get('/logout', ['as'=>'logout','uses'=>'LoginController@logout']);


Route::get('/dashboard', ['as'=>'index','uses'=>'BillsController@dashboard']);

Route::get('/admindashboard', ['as'=>'admindashboard','uses'=>'AdminController@index']);

Route::get('/getShift/{shift}', ['as'=>'getShift','uses'=>'AdminController@getShift']);


Route::get('/createBill', ['as'=>'createBill','uses'=>'BillsController@createBill']);

Route::get('/product/find', 'BillsController@searchProducts');

Route::post('/getSizePrice', ['as'=>'getSizePrice','uses'=>'BillsController@getSizePrice']);

Route::post('/addCurrentProduct', ['as'=>'addCurrentProduct','uses'=>'BillsController@addCurrentProduct']);

Route::post('/deleteCurrentProduct', ['as'=>'deleteCurrentProduct','uses'=>'BillsController@deleteCurrentProduct']);

Route::post('/submitOrder', ['as'=>'submitOrder','uses'=>'BillsController@submitOrder']);

Route::post('cancelOrder',array('as'=>'cancelOrder','uses'=>'BillsController@cancelOrder'));

Route::post('/updateReports', ['as'=>'updateReports','uses'=>'BillsController@updateReports']);

Route::get('/listTodayBill', ['as'=>'listTodayBill','uses'=>'BillsController@listTodayBill']);

Route::get('/viewTodayBill/{id}', ['as'=>'viewTodayBill','uses'=>'BillsController@viewTodayBill']);

Route::get('/reports', ['as'=>'reports','uses'=>'BillsController@reports']);

Route::get('/takeReports', ['as'=>'takeReports','uses'=>'BillsController@takeReports']);

Route::get('/shiftCloses', ['as'=>'shiftCloses','uses'=>'BillsController@shiftCloses']);

Route::get('/revenue', ['as'=>'revenue','uses'=>'BillsController@revenue']);

Route::get('/addProducts', ['as'=>'addProducts','uses'=>'ProductController@index']);

Route::post('/addProducts', ['as'=>'addProducts','uses'=>'ProductController@addProducts']);

Route::get('editProducts/{id}', array('as' => 'editProducts', 'uses' => 'ProductController@editProducts'));

Route::post('/updateProducts', ['as'=>'updateProducts','uses'=>'ProductController@updateProducts']);

Route::get('deleteProducts/{id}', ['as'=>'deleteProducts','uses'=>'ProductController@deleteProducts']);

Route::get('/listProducts', ['as'=>'listProducts','uses'=>'ProductController@listProducts']);

Route::get('/addOpeningBalance', ['as'=>'addOpeningBalance','uses'=>'ExpenseController@addOpeningBalance']);

Route::get('/addExpenses', ['as'=>'addExpenses','uses'=>'ExpenseController@index']);

Route::post('/addExpenses', ['as'=>'addExpenses','uses'=>'ExpenseController@addExpenses']);

Route::get('/listExpenses', ['as'=>'listExpenses','uses'=>'ExpenseController@listExpenses']);


Route::get('/truncate', ['as'=>'truncate','uses'=>'BillsController@truncate']);

Route::get('/monthlyReports', ['as'=>'monthlyReports','uses'=>'BillsController@monthlyReports']);

Route::post('/takeSingleDayMonthlyReports', ['as'=>'takeSingleDayMonthlyReports','uses'=>'BillsController@takeSingleDayMonthlyReports']);

Route::get('/takeSingleDayCsv/{date}', ['as'=>'takeSingleDayCsv','uses'=>'BillsController@takeSingleDayCsv']);

Route::post('/takeMultipleDayMonthlyReports', ['as'=>'takeMultipleDayMonthlyReports','uses'=>'BillsController@takeMultipleDayMonthlyReports']);

Route::get('/takeMultipleDayCsv/{fromDate}/{toDate}', ['as'=>'takeMultipleDayCsv','uses'=>'BillsController@takeMultipleDayCsv']);

Route::get('/listTotalBills', ['as'=>'listTotalBills','uses'=>'BillsController@listTotalBills']);

Route::get('/viewTotalBill', ['as'=>'viewTotalBill','uses'=>'BillsController@viewTotalBill']);

Route::get('/viewDeleteBill', ['as'=>'viewDeleteBill','uses'=>'BillsController@viewDeleteBill']);

Route::get('/viewBillDetails/{id}/{date}', ['as'=>'viewBillDetails','uses'=>'BillsController@viewBillDetails']);

Route::get('/mail', ['as'=>'mail','uses'=>'BillsController@mail']);




