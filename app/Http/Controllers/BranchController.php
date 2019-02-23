<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request){
        $branches=Branch::select('id','name','mobile','status','address')->where('status','!=',3)->get();
        return $branches;
    }

    public function store(Request $request){
       
            $branch=new Branch();
            $branch->name=$request->body['name'];
            $branch->mobile=$request->body['mobile'];
            $branch->phone=$request->body['phone'];
            $branch->email=$request->body['email'];
            $branch->address=$request->body['address'];
            $branch->status=1;
            $branch->cid=$request->session()->get('user');

            $branch->save();

            return [
                'status'=>1,
                'msg_type'=>'success',
                'message_title'=>'Successfully Add Branch'
            ];
        }



    public function sel_branch(Request $request,$id){
        $sel_user=Branch::where('id',$id)->where('status','!=',3)->first();
        return $sel_user;
    }


    public function update_branch(Request $request,$id){
        $chk=Branch::where('id',$id)->where('status','!=',3)->exists();

        if($chk){
            if($request->body['delete']==true){
                Branch::where('id',$id)->where('status','!=',3)->update([
                    'status'=>3,
                    'uid'=>$request->session()->get('user')
                ]);
                return [
                    'status'=>1,
                    'msg_type'=>'Deleted',
                    'message_title'=>'Successfully Deleted Branch'
                ];
            }else{

                Branch::where('id',$id)->where('status','!=',3)->update([
                    'name'=>$request->body['name'],
                    'mobile'=>$request->body['mobile'],
                    'phone'=>$request->body['phone'],
                    'email'=>$request->body['email'],
                    'address'=>$request->body['address'],
                    'uid'=>$request->session()->get('user')
                ]);
            }


            return [
                'status'=>1,
                'msg_type'=>'success',
                'message_title'=>'Successfully Update Branch'
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
