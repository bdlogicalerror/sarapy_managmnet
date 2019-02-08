<?php

namespace App\Http\Controllers;

use App\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function get_acc(Request $request){
        $branch_id=$request->session()->get('branch_id');
        $user=$request->session()->get('user');

        $get=client::orderBy('created_at', 'desc')->first();
        $sl=isset($get->id)?$get->id+1:1;
        $fv=sprintf("%03d%03d%02d%07d",$branch_id,$user,date('s'),$sl);
        return [
            "acc_no"=>$fv
        ];
    }

    public function index(Request $request){
        $clients=client::select('id','name','acc_number','client_type','status')
                ->where('status','!=',3)->get();
        return $clients;
    }

    public function store(Request $request){
        $branch_id=$request->session()->get('branch_id');
        $user=$request->session()->get('user');

        $get=client::orderBy('created_at', 'desc')->first();
        $sl=isset($get->id)?$get->id+1:1;
        $fv=sprintf("%03d%03d%02d%07d",$branch_id,$user,date('s'),$sl);

        $client=new client();
        $client->acc_number=$fv;
        $client->branch_id=$branch_id;
        $client->name=$request->body['name'];
        $client->mobile=$request->body['mobile'];
        $client->phone=$request->body['phone'];
        $client->email=$request->body['email'];
        $client->address=$request->body['address'];
        $client->cid=$user;
        $client->status=1;
        $client->client_type=$request->body['type'];
        $client->profile_pic=decode_img($request->body['profile_pic']);
        $client->id_card=decode_img($request->body['id_card']);
        $client->signature=decode_img($request->body['signature']);
        $client->save();
        return [
            'status'=>1,
            'msg_type'=>'success',
            'message_title'=>'Successfully Add Branch'
        ];
    }



    public function sel_client(Request $request,$id){
        $sel_user=client::where('id',$id)->where('status','!=',3)->first();
        return $sel_user;
    }


    public function update_client(Request $request,$id){
        $chk=client::where('id',$id)->where('status','!=',3)->exists();

        if($chk){
            $sel_client=client::where('id',$id)->where('status','!=',3)->first();

            if(isset($request->body['delete']) && $request->body['delete']==true){
                client::where('id',$id)->where('status','!=',3)->update([
                    'status'=>3
                ]);
                return [
                    'status'=>1,
                    'msg_type'=>'Deleted',
                    'message_title'=>'Successfully Deleted Client'
                ];
            }else{
                client::where('id',$id)->where('status','!=',3)->update([
                    'name'=>$request->body['name'],
                    'mobile'=>$request->body['mobile'],
                    'phone'=>$request->body['phone'],
                    'email'=>$request->body['email'],
                    'address'=>$request->body['address'],
                    'uid'=>$request->session()->get('user'),
                    'client_type'=>$request->body['type']
                ]);

                if(isset($request->body['profile_pic'])&& $request->body['profile_pic']!==""){

                    if(is_file(public_path().'/data/'.$sel_client->profile_pic)){
                        unlink(public_path().'/data/'.$sel_client->profile_pic);
                    }
                    client::where('id',$id)->where('status','!=',3)->update([
                        'profile_pic'=>decode_img($request->body['profile_pic'])
                    ]);
                }
                if(isset($request->body['id_card']) && $request->body['id_card']!==""){
                    if(is_file(public_path().'/data/'.$sel_client->id_card)){
                        unlink(public_path().'/data/'.$sel_client->id_card);
                    }
                    client::where('id',$id)->where('status','!=',3)->update([
                        'id_card'=>decode_img($request->body['id_card'])
                    ]);
                }
                if(isset($request->body['signature']) && $request->body['signature']!==""){
                    if(is_file(public_path().'/data/'.$sel_client->signature)){
                        unlink(public_path().'/data/'.$sel_client->signature);
                    }
                    client::where('id',$id)->where('status','!=',3)->update([
                        'signature'=>decode_img($request->body['signature'])
                    ]);
                }
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
