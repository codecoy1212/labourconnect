<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function add_user(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'u_name'=> 'required|min:3',
                'u_uname'=> 'required|min:3|unique:users,u_uname',
                'u_email'=> 'required|email:rfc,dns|unique:users,u_email',
                'u_pass'=> 'required|digits:4|numeric',
                'u_dob'=> 'required|date',
                'u_phone'=> 'required|digits:11',
            ],[
                'u_name.required' => 'Worker name is required.',
                'u_name.min' => 'Worker name must be of 3 characters.',
                'u_uname.required' => 'Worker username is required.',
                'u_uname.min' => 'Worker username must be of 3 characters.',
                'u_uname.unique' => 'Worker username is required.',
                'u_email.required' => 'Worker email is required.',
                'u_email.email' => 'Email is incorrect.',
                'u_email.unique' => 'Email already exists.',
                'u_pass.required' => 'Password is required.',
                'u_pass.digits' => 'Password must be of 4 digits.',
                'u_pass.numeric' => 'Only digits allowed in password.',
                'u_dob.required' => 'Date of birth is required.',
                'u_dob.date' => 'Incorrect date format.',
                'u_phone.required' => 'Phone is required.',
                'u_phone.digits' => 'Phone must be of 11 characters.',
                'role_id.required' => 'Role ID is required.',
                'role_id.numeric' => 'Role ID must be numeric.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = new User;
                $vbl->u_name = $request->u_name;
                $vbl->u_uname = $request->u_uname;
                $vbl->u_email = $request->u_email;
                $vbl->u_pass = $request->u_pass;
                $vbl->u_dob = $request->u_dob;
                $vbl->u_phone = $request->u_phone;
                $vbl->save();
            }
        }
        else
            return redirect('login');

    }

    public function show_users()
    {
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('users')
            ->select('users.*')
            ->orderBy('users.id','desc')->paginate(7);
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function show_user(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('users')
            ->where('users.id',$request->id)
            ->select('users.*')
            ->first();
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function edit_user(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'u_name'=> 'required|min:3',
                'u_uname'=> 'required|min:3|unique:users,u_uname,'.$request->id,
                'u_email'=> 'required|email:rfc,dns|unique:users,u_email,'.$request->id,
                'u_pass'=> 'required|digits:4|numeric',
                'u_dob'=> 'required|date',
                'u_phone'=> 'required|digits:11',
            ],[
                'u_name.required' => 'Worker name is required.',
                'u_name.min' => 'Worker name must be of 3 characters.',
                'u_uname.required' => 'Worker username is required.',
                'u_uname.min' => 'Worker username must be of 3 characters.',
                'u_uname.unique' => 'Worker username is required.',
                'u_email.required' => 'Worker email is required.',
                'u_email.email' => 'Email is incorrect.',
                'u_email.unique' => 'Email already exists.',
                'u_pass.required' => 'Password is required.',
                'u_pass.digits' => 'Password must be of 4 digits.',
                'u_pass.numeric' => 'Only digits allowed in password.',
                'u_dob.required' => 'Date of birth is required.',
                'u_dob.date' => 'Incorrect date format.',
                'u_phone.required' => 'Phone is required.',
                'u_phone.digits' => 'Phone must be of 11 characters.',
                'role_id.required' => 'Role ID is required.',
                'role_id.numeric' => 'Role ID must be numeric.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = User::find($request->id);
                $vbl->u_name = $request->u_name;
                $vbl->u_uname = $request->u_uname;
                $vbl->u_email = $request->u_email;
                $vbl->u_pass = $request->u_pass;
                $vbl->u_dob = $request->u_dob;
                $vbl->u_phone = $request->u_phone;
                $vbl->update();
            }
        }
        else
            return redirect('login');
    }

    public function del_user(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl = User::find($request->id);
            $vbl->delete();
        }
        else
            return redirect('login');

    }

    public function search_user(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $vbl = DB::table('users')
            ->select('users.*')
            ->orWhere('u_name', 'like',"%".$request->search."%")
            ->orWhere('u_uname', 'like',"%".$request->search."%")
            ->orWhere('u_email', 'like',"%".$request->search."%")
            ->orWhere('u_dob', 'like',"%".$request->search."%")
            ->orWhere('u_phone', 'like',"%".$request->search."%")
            ->orWhere('users.id', 'like', "%".$request->search."%")
            ->orderBy('created_at', 'desc')->paginate(7);
            return $vbl;
        }
        else
            return redirect('login');

    }
}
