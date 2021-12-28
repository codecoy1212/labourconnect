<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Job_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function add_job(Request $request)
    {
        // return $request;

        $vbl = new Job;
        $vbl->j_location = $request->j_location;
        $vbl->company_id = $request->company_id;
        $vbl->save();

        foreach ($request->job_users as $key ) {
            $vbl1 = new Job_User;
            $vbl1->job_id = $vbl->id;
            $vbl1->user_id = $key;
            $vbl1->save();
        }
    }

    public function show_job(Request $request)
    {
        $vbl = Job::find($request->id);
        // return $vbl;
        return view('main.main2.update_job',compact('vbl'));
    }

    // public function edit_job(Request $request)
    // {
    //     // return $request;

    //     $vbl = Job::find($request->id);
    //     $vbl->c_name = $request->c_name;
    //     $vbl->c_contact = $request->c_contact;
    //     $vbl->c_phone = $request->c_phone;
    //     $vbl->update();
    // }

    // public function del_job(Request $request)
    // {
    //     $vbl = Job::find($request->id);
    //     $vbl->delete();
    // }

    public function search_user(Request $request)
    {
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
        ->orderBy('created_at', 'desc')->paginate(3);
        return $vbl;
    }
}
