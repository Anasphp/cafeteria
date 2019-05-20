<?php

namespace App\Http\Controllers;

use App\Bill;
use App\BillEve;
use App\CurrentBills;
use App\CurrentOrders;
use App\Expense;
use App\MonthlyReports;
use App\OpeningBalance;
use App\Order;
use App\OrderEve;
use App\Product;
use App\ReportEve;
use App\Reports;
use App\Revenue;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use View;

class BillsController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = new \DateTime();
        $count = [];
        $carbon = Carbon::today('Asia/Kolkata');
        $carbon = $carbon->toDateString();
        if ($request->session()->get('value') == "1") {
            $count['todayBillCount'] = Bill::where('shift_close', 0)->count();
            $count['todayRevenue'] = Bill::where('shift_close', 0)->sum('ordered_total');
            $count['openingBalance'] = OpeningBalance::select('opening_balance_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            $count['expense'] = OpeningBalance::select('expenses_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            session(['openingBalance' => $count['openingBalance']['opening_balance_amount']]);
        } else {
            $count['todayBillCount'] = BillEve::where('shift_close', 0)->count();
            $count['todayRevenue'] = BillEve::where('shift_close', 0)->sum('ordered_total');
            $count['openingBalance'] = OpeningBalance::select('opening_balance_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            $count['expense'] = OpeningBalance::select('expenses_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            session(['openingBalance' => $count['openingBalance']['opening_balance_amount']]);
        }

        if (empty($request->session()->get('username'))) {
            return redirect()->route('login');
        } else {
            return View::make('index')->with('count', $count);
        }
    }

    public function createBill(Request $request)
    {
        if (empty($request->session()->get('username'))) {
            return redirect()->route('login');
        } else {
            return view('createbill');
        }
    }

    public function searchProducts(Request $request)
    {
        return Product::where('products_name', 'LIKE', '%' . $request->q . '%')->orWhere('products_code', 'LIKE', '%' . $request->q . '%')->get();
    }

    public function getSizePrice(Request $request)
    {
        $input = Input::get();
        return Product::where('products_name', '=', $input['value'])->first();
    }

    public function addCurrentProduct(Request $request)
    {
        $input = Input::get();
        $carbon = Carbon::now('Asia/Kolkata');
        $checkDoublePress = CurrentBills::select('ordered_time')->latest()->first();
        $seconds = 2;
        $time = date("H:i:s", (strtotime(date($checkDoublePress['ordered_time'])) + $seconds));
        if ($input['bill'] == 0) {
            $bill = new CurrentBills;
            $bill->ordered_count = 1;
            $bill->ordered_total = $input['price'] * $input['quantity'];
            $bill->ordered_date = $carbon->toDateString();
            $bill->ordered_time = $carbon->toTimeString();
            $bill->user_value = $request->session()->get('value');
            if ($bill->save()) {
                $checkDoublePress = CurrentOrders::select('created_at')->latest()->first();
                $seconds = 2;
                $time = date("H:i:s", (strtotime(date($checkDoublePress['created_at'])) + $seconds));
                $order = new CurrentOrders;
                $order->bills_id = $bill->bills_id;
                $order->order_name = $input['name'];
                $order->order_price = $input['price'];
                $order->order_quantity = $input['quantity'];
                $order->total_price = $input['price'] * $input['quantity'];
                $order->save();
                $data = [];
                $data['data'] = $order;
                $data['total'] = $bill->ordered_total;
                return $data;
            }
        } else {
            $bill = CurrentBills::find($input['bill']);
            $bill->ordered_count = $bill['ordered_count'] + 1;
            $bill->ordered_total += $input['price'] * $input['quantity'];
            $bill->ordered_date = $carbon->toDateString();
            $bill->ordered_time = $carbon->toTimeString();
            if ($bill->update()) {
                $order = new CurrentOrders;
                $order->bills_id = $bill->bills_id;
                $order->order_name = $input['name'];
                $order->order_price = $input['price'];
                $order->order_quantity = $input['quantity'];
                $order->total_price = $input['price'] * $input['quantity'];
                $order->save();
                $data = [];
                $data['data'] = $order;
                $data['total'] = $bill->ordered_total;
                return $data;
            }
        }
    }

    public function deleteCurrentProduct(Request $request)
    {
        $orderFetch = CurrentOrders::find(Input::get('id'));
        $order = CurrentOrders::destroy(Input::get('id'));
        $bill = CurrentBills::find(Input::get('bill'));
        $bill->ordered_count = $bill['ordered_count'] - 1;
        $bill->ordered_total = $bill['ordered_total'] - $orderFetch['total_price'];
        $bill->update();
        return $bill;
    }

    public function submitOrder(Request $request)
    {
        if ($request->session()->get('value') == "1") {
            if (Input::get('id') == 0) {
                $fetchCurrentBill = CurrentBills::with('orders')->where('user_value', '=', $request->session()->get('value'))->latest()->first();
            } else {
                $fetchCurrentBill = CurrentBills::with('orders')->where('user_value', '=', $request->session()->get('value'))->where('bills_id', '=', Input::get('id'))->get();
                $fetchCurrentBill = $fetchCurrentBill[0];
            }
            $fetchInvoiceNumber = OpeningBalance::select('invoice_number')->where('shift_value', $request->session()->get('value'))->first();
            $updateInvoiceNumber = OpeningBalance::where('shift_value', $request->session()->get('value'))->update(array('invoice_number' => $fetchInvoiceNumber['invoice_number'] + 1));
            $saveBill = new Bill;
            $saveBill->current_bill_id = $fetchCurrentBill['bills_id'];
            $saveBill->ordered_count = $fetchCurrentBill['ordered_count'];
            $saveBill->ordered_total = $fetchCurrentBill['ordered_total'];
            $saveBill->ordered_date = $fetchCurrentBill['ordered_date'];
            $saveBill->ordered_time = $fetchCurrentBill['ordered_time'];
            $saveBill->user_value = $request->session()->get('value');
            $saveBill->invoice_number = $fetchInvoiceNumber['invoice_number'] + 1;
            if ($saveBill->save()) {
                for ($i = 0; $i < count($fetchCurrentBill['orders']); $i++) {
                    $saveOrders = new Order;
                    $saveOrders->bills_id = $saveBill->bills_id;
                    $saveOrders->order_name = $fetchCurrentBill['orders'][$i]['order_name'];
                    $saveOrders->order_price = $fetchCurrentBill['orders'][$i]['order_price'];
                    $saveOrders->order_quantity = $fetchCurrentBill['orders'][$i]['order_quantity'];
                    $saveOrders->total_price = $fetchCurrentBill['orders'][$i]['total_price'];
                    $saveOrders->save();
                }
                return Bill::with('orders')->find($saveBill->bills_id);
            }
        } else {
            if (Input::get('id') == 0) {
                $fetchCurrentBill = CurrentBills::with('orders')->where('user_value', '=', $request->session()->get('value'))->latest()->first();
            } else {
                $fetchCurrentBill = CurrentBills::with('orders')->where('bills_id', '=', Input::get('id'))->where('user_value', '=', $request->session()->get('value'))->get();
                $fetchCurrentBill = $fetchCurrentBill[0];
            }
            $fetchInvoiceNumber = OpeningBalance::where('shift_value', $request->session()->get('value'))->first();
            $updateInvoiceNumber = OpeningBalance::where('shift_value', $request->session()->get('value'))->update(array('invoice_number' => $fetchInvoiceNumber['invoice_number'] + 1));
            $saveBill = new BillEve;
            $saveBill->current_bill_id = $fetchCurrentBill['bills_id'];
            $saveBill->ordered_count = $fetchCurrentBill['ordered_count'];
            $saveBill->ordered_total = $fetchCurrentBill['ordered_total'];
            $saveBill->ordered_date = $fetchCurrentBill['ordered_date'];
            $saveBill->ordered_time = $fetchCurrentBill['ordered_time'];
            $saveBill->user_value = $request->session()->get('value');
            $saveBill->invoice_number = $fetchInvoiceNumber['invoice_number'] + 1;
            if ($saveBill->save()) {
                for ($i = 0; $i < count($fetchCurrentBill['orders']); $i++) {
                    $saveOrders = new OrderEve;
                    $saveOrders->bills_id = $saveBill->bills_id;
                    $saveOrders->order_name = $fetchCurrentBill['orders'][$i]['order_name'];
                    $saveOrders->order_price = $fetchCurrentBill['orders'][$i]['order_price'];
                    $saveOrders->order_quantity = $fetchCurrentBill['orders'][$i]['order_quantity'];
                    $saveOrders->total_price = $fetchCurrentBill['orders'][$i]['total_price'];
                    $saveOrders->save();
                }
                return BillEve::with('orders')->find($saveBill->bills_id);
            }
        }
    }

    public function cancelOrder(Request $request)
    {
        $input = Input::get();
        $billDelete = CurrentBills::destroy($input['id']);
        $fetchOrders = CurrentOrders::select('orders_id')->where('bills_id', '=', $input['id'])->get();
        for ($i = 0; $i < count($fetchOrders); $i++) {
            CurrentOrders::destroy($fetchOrders[$i]['orders_id']);
        }
    }

    public function updateReports(Request $request)
    {
        $input = Input::get();
        if ($request->session()->get('value') == "1") {
            $bills = Bill::with('orders')->where('bills_id', '=', $input['id'])->latest()->first();
            for ($i = 0; $i < count($bills['orders']); $i++) {
                $checkExisting = Reports::where('products_name', '=', $bills['orders'][$i]['order_name'])->first();
                if (empty($checkExisting)) {
                    $report = new Reports;
                    $report->products_name = $bills['orders'][$i]['order_name'];
                    $report->product_quantity = $bills['orders'][$i]['order_quantity'];
                    $report->product_price = $bills['orders'][$i]['order_price'];
                    $report->product_total = $bills['orders'][$i]['order_price'] * $bills['orders'][$i]['order_quantity'];
                    $report->save();
                } else {
                    $checkExisting->products_name = $bills['orders'][$i]['order_name'];
                    $checkExisting->product_quantity += $bills['orders'][$i]['order_quantity'];
                    $checkExisting->product_price = $bills['orders'][$i]['order_price'];
                    $checkExisting->product_total += $bills['orders'][$i]['order_price'] * $bills['orders'][$i]['order_quantity'];
                    $checkExisting->save();
                }
            }
        } else {
            $bills = BillEve::with('orders')->where('bills_id', '=', $input['id'])->latest()->first();
            for ($i = 0; $i < count($bills['orders']); $i++) {
                $checkExisting = ReportEve::where('products_name', '=', $bills['orders'][$i]['order_name'])->first();
                if (empty($checkExisting)) {
                    $report = new ReportEve;
                    $report->products_name = $bills['orders'][$i]['order_name'];
                    $report->product_quantity = $bills['orders'][$i]['order_quantity'];
                    $report->product_price = $bills['orders'][$i]['order_price'];
                    $report->product_total = $bills['orders'][$i]['order_price'] * $bills['orders'][$i]['order_quantity'];
                    $report->save();
                } else {
                    $checkExisting->products_name = $bills['orders'][$i]['order_name'];
                    $checkExisting->product_quantity += $bills['orders'][$i]['order_quantity'];
                    $checkExisting->product_price = $bills['orders'][$i]['order_price'];
                    $checkExisting->product_total += $bills['orders'][$i]['order_price'] * $bills['orders'][$i]['order_quantity'];
                    $checkExisting->save();
                }
            }
        }
    }

    public function listTodayBill(Request $request)
    {
        if ($request->session()->get('value') == "1") {
            $listTodayBill = Bill::with('orders')->where('shift_close', 0)->latest()->paginate(5);
        } else {
            $listTodayBill = BillEve::with('orders')->where('shift_close', 0)->latest()->paginate(5);
        }
        return View::make('listtodaybill')->with('listTodayBill', $listTodayBill);
    }

    public function viewTodayBill(Request $request, $id)
    {
        if ($request->session()->get('value') == "1") {
            $viewTodayBill = Bill::with('orders')->where('shift_close', 0)->where('invoice_number', $id)->first();
        } else {
            $viewTodayBill = BillEve::with('orders')->where('shift_close', 0)->where('invoice_number', $id)->first();
        }

        return View::make('viewTodayBill')->with('viewTodayBill', $viewTodayBill);
    }

    public function reports(Request $request)
    {
        if (empty($request->session()->get('username'))) {
            return redirect()->route('login');
        } else {
            if ($request->session()->get('value') == "1") {
                $report = Reports::orderBy('products_name')->paginate(5);
            } else {
                $report = ReportEve::orderBy('products_name')->paginate(5);
            }
            return View::make('report')->with('report', $report);
        }
    }

    public function takeReports(Request $request)
    {
        if ($request->session()->get('value') == "1") {
            $reports['data'] = Reports::orderBy('products_name')->get();
            $reports['shift'] = $request->session()->get('username');
            $reports['amount'] = Reports::sum('product_total');
            $reports['today_date'] = date("Y-m-d");
            $carbonTime = Carbon::now('Asia/Kolkata');
            $time = $carbonTime->toTimeString();
            $reports['total_bills'] =Bill::where('shift_close', 0)->count();
            $reports['today_time'] = $time;
            $reports['expense'] = OpeningBalance::select('expenses_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            $reports['openingBalance'] = OpeningBalance::select('opening_balance_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            return $reports;
        } else {
            $reports['data'] = ReportEve::latest()->get();
            $reports['amount'] = ReportEve::sum('product_total');
            $reports['today_date'] = date("Y-m-d");
            $reports['shift'] = $request->session()->get('username');
            $carbonTime = Carbon::now('Asia/Kolkata');
            $time = $carbonTime->toTimeString();
            $reports['total_bills'] =BillEve::where('shift_close', 0)->count();
            $reports['today_time'] = $time;
            $reports['openingBalance'] = OpeningBalance::select('opening_balance_amount')->where('shift_value', '=', $request->session()->get('value'))->first();
            return $reports;
        }
    }

    public function shiftCloses(Request $request)
    {
        if ($request->session()->get('value') == "1") {
            $carbonDate = Carbon::today('Asia/Kolkata');
            $carbonTime = Carbon::now('Asia/Kolkata');
            $time = $carbonTime->toTimeString();
            $date = $carbonDate->toDateString();
            $report = Reports::sum('product_total');
            $revenue = Revenue::where('revenue_date', '=', $date)->where('revenue_shift', '=', $request->session()->get('value'))->first();
            if (empty($revenue)) {
                $revenue = new Revenue;
                $revenue->revenue_date = $date;
                $revenue->revenue_closed_date = $date;
                $revenue->revenue_shift = $request->session()->get('value');
                $revenue->revenue_amount = $report;
                $revenue->revenue_closed_time = $time;
            } else {
                $revenue->revenue_closed_date = $date;
                $revenue->revenue_amount += $report;
                $revenue->revenue_closed_time = $time;
            }
            if ($revenue->save()) {
                Bill::where('user_value', $request->session()->get('value'))->where('shift_close', 0)->update(array('shift_close' => 1));
                $fetchDate = OpeningBalance::select('opening_balance_date')->where('shift_value', $request->session()->get('value'))->first();
                $fetchReports = Reports::get();
                for ($i = 0; $i < count($fetchReports); $i++) {
                    $updateMonthlyReports = new MonthlyReports;
                    $updateMonthlyReports->date = $fetchDate['opening_balance_date'];
                    $updateMonthlyReports->user_shift = $request->session()->get('value');
                    $updateMonthlyReports->report_id = $fetchReports[$i]['report_id'];
                    $updateMonthlyReports->products_name = $fetchReports[$i]['products_name'];
                    $updateMonthlyReports->product_quantity = $fetchReports[$i]['product_quantity'];
                    $updateMonthlyReports->product_price = $fetchReports[$i]['product_price'];
                    $updateMonthlyReports->product_total = $fetchReports[$i]['product_total'];
                    $updateMonthlyReports->save();
                }

                $fetchMonthlyreports = MonthlyReports::where('date',$request->session()->get('shift_opening_date'))->where('user_shift',$request->session()->get('value'))->get();
                
                // if(!empty($fetchMonthlyreports)){
                //     $emails = ['anasarafath8@gmail.com', 'anasarafath.a@contus.in','anasarafath.a@dreamorbit.com'];
                //     Mail::send('mail', ['fetchMonthlyreports'=>$fetchMonthlyreports,'revenue'=>$revenue], function ($message) use ($emails) {
                //         $message->to($emails)->subject('Reports');
                //         $message->from('presidentcafe3535@gmail.com', 'Revenue Of Cup');
                //     });
                // }
                // if(!empty($fetchMonthlyreports)){
                //     $emails = ['hajeeismailhotelpresident@gmail.com', 'sallu096@gmail.com','chrono2k18@gmail.com'];
                //         foreach($emails as $email) {
                //             Mail::send('mail', ['fetchMonthlyreports'=>$fetchMonthlyreports,'revenue'=>$revenue], function ($message) use ($email) {
                //             $message->to($email)->subject('Reports');
                //             $message->from('presidentcafe3535@gmail.com', 'Revenue Of Cup');
                //         });         
                //     }
                // }
                $request->session()->forget('username');
                $request->session()->forget('value');
                Expense::query()->truncate();
                Reports::query()->truncate();
                OpeningBalance::query()->truncate();
                CurrentBills::query()->truncate();
                CurrentOrders::query()->truncate();

                return "success";
            }
        } else {
            $carbonDate = Carbon::today('Asia/Kolkata')->subDays(1);
            $carbonTime = Carbon::now('Asia/Kolkata');
            $time = $carbonTime->toTimeString();
            $date = $carbonDate->toDateString();
            $report = ReportEve::sum('product_total');
            $revenue = Revenue::where('revenue_date', '=', $date)->where('revenue_shift', '=', $request->session()->get('value'))->first();
            if (empty($revenue)) {
                $revenue = new Revenue;
                $revenue->revenue_date = $date;
                $revenue->revenue_closed_date = Carbon::today('Asia/Kolkata')->toDateString();
                $revenue->revenue_shift = $request->session()->get('value');
                $revenue->revenue_amount = $report;
                $revenue->revenue_closed_time = $time;
            } else {
                $revenue->revenue_closed_date = Carbon::today('Asia/Kolkata')->toDateString();
                $revenue->revenue_amount += $report;
                $revenue->revenue_closed_time = $time;
            }
            if ($revenue->save()) {
                BillEve::where('user_value', $request->session()->get('value'))->where('shift_close', 0)->update(array('shift_close' => 1));
                $fetchDate = OpeningBalance::select('opening_balance_date')->where('shift_value', $request->session()->get('value'))->first();
                $fetchReports = ReportEve::get();
                for ($i = 0; $i < count($fetchReports); $i++) {
                    $updateMonthlyReports = new MonthlyReports;
                    $updateMonthlyReports->date = $fetchDate['opening_balance_date'];
                    $updateMonthlyReports->user_shift = $request->session()->get('value');
                    $updateMonthlyReports->report_id = $fetchReports[$i]['report_id'];
                    $updateMonthlyReports->products_name = $fetchReports[$i]['products_name'];
                    $updateMonthlyReports->product_quantity = $fetchReports[$i]['product_quantity'];
                    $updateMonthlyReports->product_price = $fetchReports[$i]['product_price'];
                    $updateMonthlyReports->product_total = $fetchReports[$i]['product_total'];
                    $updateMonthlyReports->save();
                }
                $fetchMonthlyreports = MonthlyReports::where('date',$request->session()->get('shift_opening_date'))->where('user_shift',$request->session()->get('value'))->get();

            //     if(!empty($fetchMonthlyreports)){
            //       Mail::send('mail', ['fetchMonthlyreports'=>$fetchMonthlyreports,'revenue'=>$revenue], function ($message) {
            //         $message->to('anasarafath8@gmail.com')->subject('Reports');
            //         $message->from('presidentcafe3535@gmail.com', 'Revenue Of Cup');
            //     });
            //   }
               ReportEve::query()->truncate();
               OpeningBalance::query()->truncate();
               CurrentBills::query()->truncate();
               CurrentOrders::query()->truncate();
               $request->session()->forget('username');
               $request->session()->forget('value');
               return "success";
           }
       }
   }

   public function revenue(Request $request)
   {
    if (empty($request->session()->get('shift'))) {
        return redirect()->route('login');
    } else {
        $revenue = Revenue::where('revenue_shift', '=', $request->session()->get('value'))->latest()->limit(5)->get();
        return View::make('revenue')->with('revenue', $revenue);
    }
}

public function monthlyReports(Request $request)
{
    if (empty($request->session()->get('shift'))) {
        return redirect()->route('login');
    } else {
        $fetchDate = MonthlyReports::select('date')->groupBy('date')->where('user_shift', $request->session()->get('value'))->get();
        return View::make('monthlyReports')->with('fetchDate', $fetchDate);
    }
}

public function takeSingleDayMonthlyReports(Request $request)
{
    $fetchReports['data'] = MonthlyReports::where('date', Input::get('date'))->where('user_shift', $request->session()->get('value'))->get();
    $fetchReports['shift'] = $request->session()->get('shift');
    $fetchReports['amount'] = MonthlyReports::where('date', Input::get('date'))->where('user_shift', $request->session()->get('value'))->sum('product_total');
    return $fetchReports;
}

public function takeSingleDayCsv(Request $request, $date)
{
    $items = MonthlyReports::select('date AS Date', 'products_name AS Item', 'product_quantity AS Quantity', 'product_price AS Price', 'product_total as Total')->where('date', $date)->where('user_shift', $request->session()->get('value'))->get();
    $revenue = Revenue::where('revenue_date', $date)->where('revenue_shift', $request->session()->get('value'))->first();
    $items[count($items)] = ['Date'=>'','Item'=>'','Quantity'=>'','Price'=>'Grand Total','Total'=>$revenue['revenue_amount']];
    Excel::create('reports', function ($excel) use ($items) {
        $excel->sheet('ExportFile', function ($sheet) use ($items) {
            $sheet->fromArray($items);
        });
    })->export('csv');
}

public function takeMultipleDayMonthlyReports(Request $request)
{
    $date = Input::get('date');
    $fetchReports['data'] = MonthlyReports::whereBetween('date', [$date['from'], $date['to']])->where('user_shift', $request->session()->get('value'))->get();
    $fetchQuantity = MonthlyReports::whereBetween('date', [$date['from'], $date['to']])->where('user_shift', $request->session()->get('value'))->groupBy('products_name')->selectRaw('sum(product_quantity) as quantity, products_name')
    ->pluck('quantity', 'products_name');
    $productPrice = [];
    foreach ($fetchQuantity as $key => $value) {
        $fetchPrice = Product::where('products_name', $key)->select('products_price')->first();
        $productPrice[$key] = $fetchPrice['products_price'];
    }
    $fetchReports['fetchQuantity'] = $fetchQuantity;
    $fetchReports['productPrice'] = $productPrice;
    $productData['data'] = [];
    $product['revenue'] = 0;
    foreach ($fetchQuantity as $key => $value) {
        $product['name'] = $key;
        $product['quantity'] = $value;
        $product['price'] = $fetchReports['productPrice'][$key];
        $product['amount'] = $product['price'] * $product['quantity'];
        $product['revenue'] += $product['amount'];
        array_push($productData['data'], $product);
    }
    $productData['shift'] = $request->session()->get('shift');
    return $productData;
}

public function takeMultipleDayCsv(Request $request, $fromDate, $toDate)
{
    $items = MonthlyReports::select('date AS Date', 'products_name AS Item', 'product_quantity AS Quantity', 'product_price AS Price', 'product_total as Total')->whereBetween('date', [$fromDate, $toDate])->where('user_shift', $request->session()->get('value'))->get();
    $revenue = Revenue::whereBetween('revenue_date', [$fromDate, $toDate])->where('revenue_shift', $request->session()->get('value'))->get();
    $total_revenue = 0;
    foreach ($revenue as $data) {
     $total_revenue += $data['revenue_amount'];
 }

 $items[count($items)] = ['Date'=>'','Item'=>'','Quantity'=>'','Price'=>'Grand Total','Total'=>$total_revenue];
 Excel::create('reports', function ($excel) use ($items) {
    $excel->sheet('ExportFile', function ($sheet) use ($items) {
        $sheet->fromArray($items);
    });
})->export('csv');
}

public function listTotalBills(Request $request)
{
    $listTotalBills = MonthlyReports::where('user_shift', $request->session()->get('value'))->groupBy('date')->selectRaw('sum(product_total) as total, date')
    ->pluck('total', 'date');
    return View::make('listtotalbill')->with('listTotalBills', $listTotalBills);
}

public function viewTotalBill(Request $request)
{
    if ($request->session()->get('value') == "1") {
        $viewBill = Bill::with('orders')->where('shift_close', 1)->where('ordered_date', Input::get('date'))->where('user_value', $request->session()->get('value'))->get();
    } else {
        $viewBill = BillEve::with('orders')->where('shift_close', 1)->where('ordered_date', Input::get('date'))->where('user_value', $request->session()->get('value'))->get();
    }
    return View::make('viewTotalBill')->with('viewBill', $viewBill);
}

public function viewDeleteBill(Request $request)
{
    if ($request->session()->get('value') == "1") {
        $viewDeleteBill = Bill::with('orders')->where('shift_close', 1)->where('ordered_date', Input::get('date'))->where('user_value', $request->session()->get('value'))->delete();
        $DeleteReport = MonthlyReports::where('date', Input::get('date'))->where('user_shift', $request->session()->get('value'))->delete();
        $DeleteRevenue = Revenue::where('revenue_date', Input::get('date'))->where('revenue_shift', $request->session()->get('value'))->delete();
    } else {
        $viewDeleteBill = BillEve::with('orders')->where('shift_close', 1)->where('ordered_date', Input::get('date'))->where('user_value', $request->session()->get('value'))->delete();
        $DeleteReport = MonthlyReports::where('date', Input::get('date'))->where('user_shift', $request->session()->get('value'))->delete();
        $DeleteRevenue = Revenue::where('revenue_date', Input::get('date'))->where('revenue_shift', $request->session()->get('value'))->delete();
    }
    return redirect()->route('listTotalBills');
}

public function viewBillDetails(Request $request, $id, $date)
{
    if ($request->session()->get('value') == "1") {
        $viewBillDetails = Bill::with('orders')->where('shift_close', 1)->where('invoice_number', $id)->where('ordered_date', $date)->first();
    } else {
        $viewBillDetails = BillEve::with('orders')->where('shift_close', 1)->where('invoice_number', $id)->where('ordered_date', $date)->first();
    }

    return View::make('viewBillDetails')->with('viewBillDetails', $viewBillDetails);
}

public function truncate()
{
    Bill::query()->truncate();
    Order::query()->truncate();
    CurrentBills::query()->truncate();
    CurrentOrders::query()->truncate();
    Reports::query()->truncate();
    Expense::query()->truncate();
    OpeningBalance::query()->truncate();
    BillEve::query()->truncate();
    OrderEve::query()->truncate();
    ReportEve::query()->truncate();
    MonthlyReports::query()->truncate();
    return "Truncated";
}

public function csv(Request $request)
{
    $items = MonthlyReports::select('date AS Date', 'products_name AS Item', 'product_quantity AS Quantity', 'product_price AS Price', 'product_total as Total')->where('date', '2019-01-13')->where('user_shift', $request->session()->get('value'))->get();
    Excel::create('items', function ($excel) use ($items) {
        $excel->sheet('ExportFile', function ($sheet) use ($items) {
            $sheet->fromArray($items);
        });
    })->export('xls');
}

public function mail()
{
    Mail::send('emailtemplate', [], function ($message) {
        $message->to('anasarafath8@gmail.com')->subject('Reports');
        $message->from('presidentcafe3535@gmail.com', 'Cup Support');
    });
    return "success";
}
}
