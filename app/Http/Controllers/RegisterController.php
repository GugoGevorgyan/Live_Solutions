<?php

namespace App\Http\Controllers;

use App\Mail\LiveSolutions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $rules = [
            'fullName' => 'required|alpha',
            'phone' => 'required|numeric|digits_between:7,20',
            'address' => 'required',
            'passport' =>'required|alpha_num',
            'site' => 'required',
            'code' => 'required|numeric|digits_between:8,8',
            'email' => 'sometimes|required|email',
            'password' => 'required',
        ];


        $customMessages = [
            'required' => 'The :attribute field is required.'
        ];
        try {
            $res = $this->validate($request, $rules, $customMessages);
        }catch (\Exception $err){
            return $err;
        }

        $code = Str::random(20).time();

        $toEmail = $this->send($code,$request['email']);

//        if ($toEmail === 'true'){
            User::create([
                'fullName' => $request['fullName'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'passport' => $request['passport'],
                'site' => $request['site'],
                'code' => $request['code'],
                'status' => $code,
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role_id' => $request['role_id'],
            ]);
            return "dashboard";
//        }
//        return  $request->email ." is unavailable: user not found ";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function send($code, $email)
    {
        $toEmail = $email;

        try {
            Mail::to($toEmail)->send(new LiveSolutions($code));

        }catch (\Exception $err){
            return $err;
        }
        return 'true';
    }

    public function verify(Request $request)
    {

        DB::table('users')->where('status',$request->code)->update(['status'=>1]);
        return 'ok';
    }
}
