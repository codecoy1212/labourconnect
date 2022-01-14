<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
use App\Models\Job_User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function add_job(Request $request)
    {
        // return $request;

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
                $vbl->j_status = "ACTIVE";
                $vbl->save();

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    $i = 0;
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->role_id = $request->users_role[$i];
                        $i++;
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
            ->join('roles','roles.id','=','job__users.role_id')
            ->select('users.id','users.u_name','roles.id as role_id','roles.r_name')
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
            $vbl = Company::all();

            $vbl3 = Role::all();

            $vbl9 = Job::where('id',$request->id)->first();

            return view('main.main2.update_job',compact('vbl','vbl9','vbl3'));
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
                $vbl->j_status = "ACTIVE";
                $vbl->save();

                $vbl2 = Job_User::where('job_id',$request->job_id)->get();
                foreach ($vbl2 as $key ) {
                    $key->delete();
                }

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    $i = 0;
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->role_id = $request->users_role[$i];
                        $i++;
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

    public function show_user_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl2 = Role::where('id',$request->role_id)->first();

            $vbl = DB::table('users')
            ->where('users.id',$request->id)
            ->select('users.*')
            ->first();
            return array($vbl,$vbl2);
        }
        else
            return redirect('login');
    }

    public function fetch_jobs()
    {
        $jobs = array();

        $vbl = DB::table('jobs')
        ->where('j_status','=','ACTIVE')
        ->join('companies','companies.id','=','jobs.company_id')
        ->select('jobs.id','jobs.j_location','companies.c_contact')
        ->get();
        // return $vbl;

        foreach ($vbl as $key) {
            $vbl2 =  DB::table('job__users')
            ->where('job_id','=',$key->id)
            ->select('job__users.*')
            ->get();
            $key->workers_count = count($vbl2);
            array_push($jobs,$key);
        }
        return $jobs;
    }

    public function fetch_jobs_completed()
    {
        $jobs = array();

        $vbl = DB::table('jobs')
        ->where('j_status','=','INACTIVE')
        ->join('companies','companies.id','=','jobs.company_id')
        ->select('jobs.id','jobs.j_location','companies.c_contact')
        ->get();
        // return $vbl;

        foreach ($vbl as $key) {
            $vbl2 =  DB::table('job__users')
            ->where('job_id','=',$key->id)
            ->select('job__users.*')
            ->get();
            $key->workers_count = count($vbl2);
            array_push($jobs,$key);
        }
        return $jobs;
    }

    public function mark_complete(Request $request)
    {
        // return $request;

        $vbl = Job::find($request->id);
        $vbl->j_status = "INACTIVE";
        $vbl->update();
        // return $vbl;
    }

    public function completed()
    {
        if(session()->get('s_uname'))
        {
            $vbl4 = Job::where('j_status',"ACTIVE")->get();
            $vbl4 = count($vbl4);

            return view('main.c_jobs',compact('vbl4'));
        }
        else
            return redirect('login');
    }

    public function completed_show(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl9 = Job::where('id',$request->id)->first();

            $vbl = Company::find($vbl9->id);

            return view('main.main2.com_specific',compact('vbl','vbl9'));
        }
        else
            return redirect('login');
    }
}
