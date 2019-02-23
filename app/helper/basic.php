<?php
/**
 * FileName: basic.php
 * Created by Munna Khan.
 * Email: <engrmunnakhan@gmail.com>
 * Date: 2/7/19
 * Time: 10:41 AM
 */
function decode_img($image){
    if($image && $image!=="" && !is_array($image)){
        $dec=explode(',',$image);
        if(is_array($dec)&& array_key_exists(1,$dec)){
            $img=base64_decode($dec[1]);
            $ex=explode('/',$dec[0]);

            $rx=explode(';',$ex[1]);



            $extension='';
            switch ($rx[0]){
                case('jpeg'):
                    $extension='.jpg';
                    break;
                case('png'):
                    $extension=".png";
                    break;
                case('gif'):
                    $extension=".gif";
                    break;
                case('pdf'):
                    $extension=".pdf";
                    break;
                default:
                    $extension=".mk";
                    break;


            }
            $file_name=str_random(10).time().$extension;
            //\Illuminate\Support\Facades\File::put(storage_path(). '/' . $file_name, $image);
            if(file_put_contents(public_path().'/data/'.$file_name, $img)){
                return $file_name;
            }else{
                return null;
            }
        }else{
            return null;
        }

    }
}

function transaction_id($branch_id,$user,$sl){
    $digits = 15;
    $t_id=$branch_id.$user.$sl;
    $trans_id=str_pad(rand(0, pow(10, $digits-strlen($t_id))), $digits, $t_id, STR_PAD_LEFT);

    $chk_trans=\App\transaction::where('transaction_id',$trans_id)->exists();

    if($chk_trans){
        transaction_id($branch_id,$user,$sl);
    }else{
        return $trans_id;
    }
}

function delete_old_file($file_with_path){
    if(is_file($file_with_path)){
        unlink($file_with_path);
    }else{
        return false;
    }
}
