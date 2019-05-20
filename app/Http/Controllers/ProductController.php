<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Product;
use View;

class ProductController extends Controller
{
    public function index(Request $request) {
    	if(empty($request->session()->get('username'))) {
            return redirect()->route('login');
        } else {
            return view('addproduct');
        }
    }

    public function addProducts() {
    	$input = Input::all();
    	$product = new Product;
    	$product->products_name = $input['products_name'];
    	$product->products_code = $input['products_code'];
    	$product->products_price = $input['products_price'];
    	$product->save();
        return redirect()->route('addProducts');

    }

    public function editProducts($id) {
        $product = Product::find($id);
        return View::make('editProduct')->with('product', $product);
    }

    public function updateProducts() {
        $input = Input::all();
        $product = Product::find($input['id']);
        $product->products_name = $input['products_name'];
        $product->products_code = $input['products_code'];
        $product->products_price = $input['products_price'];
        $product->save();
        return redirect()->route('listProducts');
    }

    public function listProducts() {
        $listProducts = Product::latest()->paginate(5);
        return View::make('listproduct')->with('listProducts', $listProducts);
    }

    public function deleteProducts($id) {
        $product = Product::destroy($id);
        return redirect()->route('listProducts');
    }

}
