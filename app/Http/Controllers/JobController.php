<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\Job_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function add_job(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'j_location'=> 'required|min:5',
                'company_id'=> 'required|numeric',
            ],[
                'j_location.required' => 'Location is required.',
                'j_location.min' => 'Location must be of 5 characters.',
                'company_id.required' => 'Company ID is required.',
                'company_id.numeric' => 'Company ID should be numeric.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = new Job;
                $vbl->j_location = $request->j_location;
                $vbl->company_id = $request->company_id;
                $vbl->save();

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->save();
                    }
                }
            }
        }
        else
            return redirect('login');

    }

    public function show_job_det(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return "hello";
            $job = array();

            $vbl = DB::table('jobs')
            ->where('jobs.id',$request->id)
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('jobs.id','jobs.j_location','companies.c_name','jobs.company_id')
            ->first();
            array_push($job,$vbl);
            // return $vbl;


            $vbl2 = DB::table('job__users')
            ->where('job_id','=',$vbl->id)
            ->join('users','users.id','=','job__users.user_id')
            ->select('users.id','users.u_name')
            ->get();
            array_push($job,$vbl2);
            return $job;
        }
        else
            return redirect('login');

    }

    public function show_job(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl10 = Company::all();

            $vbl9 = Job::where('id',$request->id)->first();

            return view('main.main2.update_job',compact('vbl10','vbl9'));
        }
        else
            return redirect('login');

    }

    public function edit_job(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'j_location'=> 'required|min:5',
                'company_id'=> 'required|numeric',
            ],[
                'j_location.required' => 'Location is required.',
                'j_location.min' => 'Location must be of 5 characters.',
                'company_id.required' => 'Company ID is required.',
                'company_id.numeric' => 'Company ID should be numeric.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = Job::find($request->job_id);
                $vbl->j_location = $request->j_location;
                $vbl->company_id = $request->company_id;
                $vbl->update();

                $vbl2 = Job_User::where('job_id',$request->job_id)->get();
                foreach ($vbl2 as $key ) {
                    $key->delete();
                }

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->save();
                    }
                }
            }
        }
        else
            return redirect('login');
    }

    public function del_job(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl2 = Job_User::where('job_id',$request->id)->get();
            foreach ($vbl2 as $key ) {
                $key->delete();
            }

            $vbl1 = Job::find($request->id);
            $vbl1->delete();
        }
        else
            return redirect('login');

    }

    public function search_user(Request $request)
    {
        if(session()->get('s_uname'))
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
        else
            return redirect('login');

    }
}
