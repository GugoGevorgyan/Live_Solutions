<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Product();
        return $product->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:255',
        ]);

        $images=array();
        if($files = $request->file('images')){
            foreach($files as $file){
                $name=time().$file->getClientOriginalName();
                $file->storeAs('images', $name);
                $images[]=$name;
            }
        }

        Product::insert( [
            'image'=>  json_encode($images),
            'description' =>$request->description,
            'name' => $request->name,
            'brand_id'=>$request->brand_id,
            'status' => 1,
            'company_id' => Auth::user()->id,

        ]);
        return 'Your product has been sent';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Product $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $added_images=array();
        $existed_images = $request->existed_images;
        if($files = $request->file('added_images')){
            foreach($files as $file){
                $name=time().$file->getClientOriginalName();
                $file->storeAs('images', $name);
                $added_images[]=$name;
                array_push($existed_images, $name);
            }
        }
        if ($files = $request->file('deleted_images')){
            foreach ($files as $file){
                Storage::delete('images'.$file);
            }
        }
        $product->update([
            'image' => json_encode($existed_images),
        ]);
        return $existed_images;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
    }

    public function attach_new_product(Request $request)
    {
        try {
            $product = Product::find($request->product_id);
            $user = User::find($request->company_id);
            if ($user->products->contains($request->product_id) || $product==null) {
                return "Something is wrong in your data";
            } else {
                $user->products()->attach($product, ["count" => $request->count, "price" => $request->price,
                    "discount" => $request->discount]);
                return "Ok";
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }

    public function detach_product(Request $request){
        try {
            $product = Product::find($request->product_id);
            $user = User::find($request->company_id);
            if ($user->products->contains($request->product_id)) {
                $user->products()->detach($product);
            } else {
                return "asdsfdsf";
            }
        }catch (\Exception $ex){
            return $ex;
        }
    }


    public function getsome(Request $request){

//        return DB::table('users')
//            ->select('users.fullName', 'products.name', 'brands.name as Brand Name', 'count','discount')
//            ->leftJoin('product_user', 'users.id', '=', 'product_user.user_id')
//            ->leftJoin('products', 'products.id', '=', 'product_user.product_id')
//            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
//            ->where('users.id', '=', $request->user_id)
//            ->get();
//    }

        $user = User::find($request->user_id)->with('products.brand')->where('id',$request->user_id)->get();
        return $user;
//        $user = User::find($request->user_id);
//        $a = [];
//
//        $products = $user->products;
//        foreach ($products as $product){
//            array_push($a, $product->name);
//            array_push($a, $product->brand->name);
//        }
//        return $a;
    }

    public function company_suggest(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'images.*' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|max:255',
        ]);

        $images=array();
        if($files = $request->file('images')){
            foreach($files as $file){
                $name=time().$file->getClientOriginalName();
                $file->storeAs('images', $name);
                $images[]=$name;
            }
        }

        Product::insert( [
            'image'=>  json_encode($images),
            'description' =>$request->description,
            'name' => $request->name,
            'brand_id'=>$request->brand_id,
            'status' => 0,
            'company_id' => Auth::user()->id,
        ]);

        return "Your product is discussing";
    }


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
