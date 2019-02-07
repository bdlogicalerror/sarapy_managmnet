<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $users=User::where('users.status','!=',3)
                    ->leftJoin('branches','users.branch_id','=','branches.id')
                    ->select('branches.name AS branch','users.id','users.password','users.first_name','users.last_name','users.status','users.user_type','users.username')
                    ->get();
        return $users;
    }

    public function store(Request $request){
        $chk=User::where('username',$request->body['username'])->exists();
        if($chk){
            return [
                'status'=>0,
                'msg_type'=>'error',
                'message_title'=>'username already exists'
            ];
        }else{
            $user=new User();
            $user->first_name=$request->body['first_name'];
            $user->last_name=$request->body['last_name'];
            $user->username=$request->body['username'];
            $user->password=$request->body['password'];
            $user->status=1;
            $user->branch_id=$request->body['branch'];
            $user->user_type=$request->body['user_type'];

            $user->save();

            return [
                'status'=>1,
                'msg_type'=>'success',
                'message_title'=>'Successfully Add User'
            ];
        }

    }

    public function sel_user(Request $request,$id){
        $sel_user=User::where('id',$id)->where('status','!=',3)->first();
        return $sel_user;
    }


    public function update_user(Request $request,$id){
        $chk=User::where('id',$id)->where('status','!=',3)->exists();

        if($chk){
            if($request->body['delete']==true){
                User::where('id',$id)->where('status','!=',3)->update([
                    'status'=>3
                ]);
            }else{
                $user=User::where('id',$id)->where('status','!=',3)->first();
                User::where('id',$id)->where('status','!=',3)->update([
                    'first_name'=>$request->body['first_name'],
                    'last_name'=>$request->body['last_name'],
                    'username'=>$request->body['username'],
                    'user_type'=>$request->body['user_type'],
                    'branch_id'=>$request->body['branch'],
                    'password'=>isset($request->body['password'])?$request->body['password']:$user->password
                ]);
            }


            return [
                'status'=>1,
                'msg_type'=>'success',
                'message_title'=>'Successfully Update User'
            ];
        }else{
            return [
                'status'=>0,
                'msg_type'=>'error',
                'message_title'=>'not found'
            ];
        }
    }
}
