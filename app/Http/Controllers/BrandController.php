<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Products;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brend = new Brand();
        return $brend->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(5);
//return $user->products;
        $a =[];
        foreach ($user->products as $prod) {
//            echo $prod->pivot->created_at;
            $a[] = $prod;
        }
        //    $a[0]->pivot;
//        $product = User::find(5)->products()->orderBy('name')->get();
//
        $user = User::find(5);

        foreach ($user->products as $role) {
//            echo
            $pivot = $role->pivot->brand_id;

//$user = DB::table("users")->where("id", 5)
//    ->join('products_user','products_user.user_id','users.id' )
//->get();

return $user;




            $users = DB::table('products')->where('brand_id',$pivot)
                -> Join('brands', 'brands.id','products.brand_id')
//            ->join('products', 'brand.id','orders.user_id')
//            join('products', 'users.id','orders.user_id')
                ->select('brands.*', 'brands.name,','Br')
                ->get();


//            $users = DB::table('products')->where('brand_id',$pivot)
//            ->Join('brands', 'brands.id', '=', 'products.brand_id')
//            ->get();
            return $users;
        }

//return $product[0]->pivot->created_at;


//        $users = DB::table('products_user')->where('user_id',5)
//            ->Join('users', 'users.id', '=', 'products_user=1.user_id')
//            ->get();

//        $users = $users[0]->products_id;
//        $users1 = DB::table('products')->where('id',$users[0]->products_id)
//            ->Join('brands', 'users.id', '=', 'products_user.user_id')
//            ->get('products_id');

//$users = $users->products_id;
//        $users = User::find(1);
//        $users->p;
//        $users ->get();
//        $users = DB::table('products')
//            -> Join('products_user', 'user.id','products_user.user_id')
////            ->join('products', 'brand.id','orders.user_id')
////            join('products', 'users.id','orders.user_id')
//            ->select('products.*', 'brand.id, ',' BRAND_NAME')
//            ->get();
//        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brend = new Brand();
       if ($request->name !== null){
           $request->validate([
               'name' => 'alpha|required',
           ]);
           $brend->name = $request->name;
           $brend->save();
           return "add brend successfully";
       }
       return 'please write brand name';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $brend = new Brand();
        if ($request->name !== null){
             $request->validate([
                'name' => 'alpha|required',
            ]);
            $brend::where('id', $id)->update([
                'name'=> $request->name,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        Brand::destroy($brand->id);
    }
}
