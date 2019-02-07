<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;

class LicenseController extends Controller
{


    public function store(Request $request){
        $get=Option::where('name','key')->exists();

        if($get){
            Option::where('name','key')->update([
               'value'=>$request->key
            ]);

            return redirect('/');

        }else{
            $option=new Option();
            $option->name='key';
            $option->value=$request->key;

            if($option->save()){
                return redirect('/');
            }else{
                return redirect('/');
            }
        }
    }

}
