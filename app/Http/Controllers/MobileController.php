<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MobileController extends Controller
{
    public function login(Request $request)
    {
        // return "hello";

        $eml = $request->email;
        $pwd = $request->password;
        $dbpwd = "";
        $verification = User::where('u_email',$eml) -> first();
        // echo $verification;

        if($verification)
        {
            if($pwd == $verification->u_pass)                  //main directory is here
            {
                $token = $verification->createToken($verification->u_email)->plainTextToken;

                $dbpwd = $verification->u_pass;
                $str['status']=true;
                $str['message']="STUDENT LOGGED IN";
                $str['data']=$verification;
                $str['token']=$token;
                return $str;
            }
            else
            {
                $validator = Validator::make($request->all(),[
                'password' => ['required',Rule::in($dbpwd)],
                ], [
                'password.in' => 'PIN is Incorrent.',
                'password.required' => 'Please enter your 4 digit PIN.',
                ]);

                if ($validator->fails())
                {
                    $str['status']=false;
                    $error=$validator->errors()->toArray();
                    foreach($error as $x_value){
                        $err[]=$x_value[0];
                    }
                    $str['message'] =$err['0'];
                    return $str;
                }
            }

        }
        else
        {
            $validator = Validator::make($request->all(),[
            'email'=>'required|exists:users,u_email|email:rfc,dns',
            'password' => 'required',
            ], [
            'password.required' => 'Please enter your 4 digit PIN.',
            'email.required' => 'Please enter your Email.',
            'email.exists' => 'Email is not Registered.',
            'email.email' => 'Email is Invalid.',
            ]);

            if ($validator->fails())
            {
                $str['status']=false;
                $error=$validator->errors()->toArray();
                foreach($error as $x_value){
                    $err[]=$x_value[0];
                }
                $str['message'] =$err['0'];
                // $str['data'] = $validator->errors()->toArray();
                return $str;
            }
        }
    }

    public function logout(Request $request)
    {
        // return $request;

        $vbl = User::find($request->user_id);

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="LOGIN ID DOES NOT EXIST";
            return $str;
        }
        else
        {
            $request->user()->currentAccessToken()->delete();
            $str['status']=true;
            $str['message']="USER LOG OUT SUCCESSFULL";
            return $str;
        }
    }

    public function profile(request $request){

        $vbl = User::find($request->user_id);
        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="USER PROFILE NOT FOUND";
            return $str;
        }
        else
        {
            $str['status']=true;
            $str['message']="USER PROFILE SHOWN";
            $str['data']=$vbl;
            return $str;
        }
    }
}
