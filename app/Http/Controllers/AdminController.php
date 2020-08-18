<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class AdminController extends Controller
{
    public function accept(Request $request){
        $product = Product::find($request->product_id);
        $product->status = 1;
        $product->save();
        return "Your product has been accepted";
    }

    public function reject(Request $request){
        $product = Product::find($request->product_id);
        $product->delete();
    }
}
