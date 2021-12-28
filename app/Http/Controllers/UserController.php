<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function add_user(Request $request)
    {
        // return $request;

        $vbl = new User;
        $vbl->u_name = $request->u_name;
        $vbl->u_uname = $request->u_uname;
        $vbl->u_email = $request->u_email;
        $vbl->u_pass = $request->u_pass;
        $vbl->u_dob = $request->u_dob;
        $vbl->u_phone = $request->u_phone;
        $vbl->role_id = $request->role_id;
        $vbl->save();
    }

    public function show_users()
    {
        $vbl = DB::table('users')
        ->join('roles','roles.id','=','users.role_id')
        ->select('users.*','roles.r_name')
        ->orderBy('users.id','desc')->paginate(7);
        return $vbl;
    }

    public function show_user(Request $request)
    {
        $vbl = DB::table('users')
        ->where('users.id',$request->id)
        ->join('roles','roles.id','=','users.role_id')
        ->select('users.*','roles.r_name')
        ->first();
        return $vbl;
    }

    public function edit_user(Request $request)
    {
        // return $request;

        $vbl = User::find($request->id);
        $vbl->u_name = $request->u_name;
        $vbl->u_uname = $request->u_uname;
        $vbl->u_email = $request->u_email;
        $vbl->u_pass = $request->u_pass;
        $vbl->u_dob = $request->u_dob;
        $vbl->u_phone = $request->u_phone;
        $vbl->role_id = $request->role_id;
        $vbl->update();
    }

    public function del_user(Request $request)
    {
        $vbl = User::find($request->id);
        $vbl->delete();
    }

    public function search_user(Request $request)
    {
        // return $request;

        $vbl = DB::table('users')
        ->join('roles','roles.id','=','users.role_id')
        ->select('users.*','roles.r_name')
        ->where('r_name', 'like',"%".$request->search."%")
        ->orWhere('u_name', 'like',"%".$request->search."%")
        ->orWhere('u_uname', 'like',"%".$request->search."%")
        ->orWhere('u_email', 'like',"%".$request->search."%")
        ->orWhere('u_dob', 'like',"%".$request->search."%")
        ->orWhere('u_phone', 'like',"%".$request->search."%")
        ->orWhere('users.id', 'like', "%".$request->search."%")
        ->orderBy('created_at', 'desc')->paginate(7);
        return $vbl;
    }
}
