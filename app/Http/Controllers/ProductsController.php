<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Products();
//        return $product->all();
        auth()->user()->role_id;
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

        Products::insert( [
            'image'=>  json_encode($images),
            'description' =>$request->description,
            'name' => $request->name,
            'brand_id'=>$request->brand_id,
        ]);
        return 'Your product has been sent';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $products)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }

    public function attach_new_product(Request $request){

        try {
            $product = Products::find($request->product_id);
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

    public function product_edit(Request $request, Products $product){
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

    public function product_delete(Request $request, Products $product){
        Products::destroy($product->id);
    }

    public function getsome(){
        $latestPosts = DB::table('users')
            ->join('products_user', 'users.id', '=', 'products_user.user_id');

        return $users = DB::table('products')
            ->rightJoinSub($latestPosts, 'latest_posts', function ($join) {
                $join->on('products.id', '=', 'latest_posts.products_id');
            })->get();
    }

}
