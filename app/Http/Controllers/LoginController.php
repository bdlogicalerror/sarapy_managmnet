<?php

namespace App\Http\Controllers;

use App\login;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function check(Request $request){
        return view('welcome');

    }

    public function login_session(Request $request){
        $login=false;
        if($request->session()->get('login')!==null){
            $login=true;
        }else{
            $login=false;
        }
        return [
            "login"=>$login,
            "role"=>$request->session()->get('user_type')
        ];
    }

    public function login(Request $request){
        $user_name=$request->body['username'];
        $password=$request->body['password'];

        $sel=login::where('username',$user_name)->exists();
        if($sel){
            $get=login::where('username',$user_name)->first();
            if($get->username==$user_name && $get->password==$password){
                session()->put([
                    'login'=>true,
                    'user'=>$get->id,
                    'user_type'=>$get->user_type,
                    'branch_id'=>$get->branch_id
                ]);
                return [
                  'status'=>true
                ];
            }else{
                return [
                    'status'=>false
                ];
            }
        }else{


            return [
                'status'=>false
            ];
        }
    }

    public function logout(Request $request){
        if(session('login')){
            session()->forget([
                'login',
                'user'
            ]);
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}
