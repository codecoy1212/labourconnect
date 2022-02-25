<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DoneJob;
use App\Models\Job;
use App\Models\Job_User;
use App\Models\Role;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
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
                'j_date'=> 'required|date_format:Y-m-d',
                // 'charge_rate'=> 'required|numeric',
                // 'charge_rate_ot'=> 'required|numeric',
                // 'p_end'=> 'required|date_format:H:i',
                // 'p_start'=> 'required|date_format:H:i',
                // 'p_rate'=> 'required|numeric',
                // 'sat_rate'=> 'required|numeric',
                // 'sun_rate'=> 'required|numeric',
            ],[
                'j_location.required' => 'Location is required.',
                'j_location.min' => 'Location must be of 5 characters.',
                'company_id.required' => 'Company ID is required.',
                'company_id.numeric' => 'Company ID should be numeric.',
                'j_date.required' => 'Date is required for Job to be submitted.',
                'j_date.date_format' => 'Incorrect date format. Format:DD/MM/YYYY.',
                // 'p_end.required'=> 'Penality End time is required.',
                // 'p_start.required'=> 'Penality Start time is required.',
                // 'p_end.date_format'=> 'Penality End time format is Incorrect.',
                // 'p_start.date_format'=> 'Penality Start time format is Incorrect.',
                // 'p_rate.required'=> 'Penality Rate is required.',
                // 'p_rate.numeric'=> 'Penality Rate must be numeric.',
                // 'sat_rate.required'=> 'Saturday Penality Rate is required.',
                // 'sat_rate.numeric'=> 'Saturday Penality Rate must be numeric.',
                // 'sun_rate.required'=> 'Sunday Penality Rate is required.',
                // 'sun_rate.numeric'=> 'Sunday Penality Rate must be numeric.',
                // 'charge_rate.required'=> 'Client Charge Rate is required.',
                // 'charge_rate.numeric'=> 'Client Charge Rate must be numeric.',
                // 'charge_rate_ot.required'=> 'Client Charge Rate (OT) is required.',
                // 'charge_rate_ot.numeric'=> 'Client Charge Rate (OT) must be numeric.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                // $vbl1 = date('d/m/Y h:i:s A');
                // $vbl1 = $request->date;
                // $time = date('d/m/Y',strtotime($vbl1));
                // return $time;

                $vbl = new Job;
                $vbl->j_location = $request->j_location;
                $vbl->company_id = $request->company_id;

                // $date = str_replace('/', '-', $request->j_date);
                // $new_date = date('Y-m-d', strtotime($date));
                // $vbl->j_date = $new_date;

                $vbl->j_date = $request->j_date;
                // $vbl->charge_rate = $request->charge_rate;
                // $vbl->charge_rate_ot = $request->charge_rate_ot;
                $vbl->j_status = "ACTIVE";
                // $vbl->p_start = $request->p_start;
                // $vbl->p_end = $request->p_end;
                // $vbl->p_rate = $request->p_rate;
                // $vbl->sat_rate = $request->sat_rate;
                // $vbl->sun_rate = $request->sun_rate;
                $vbl->save();

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    // $j=0;
                    // $p_role_name = array();
                    // $p_role_price = array();
                    // foreach ($request->roles_prices as $value) {
                    //     if($j % 2 == 0)
                    //     array_push($p_role_name,$value);
                    //     else
                    //     array_push($p_role_price,$value);
                    //     $j++;
                    // }
                    // return array($p_role_name,$p_role_price);

                    // return $request->users_rates;
                    $i = 0;
                    // return $request->job_users[0];
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->role_id = $request->users_role[$i];

                        $arr = $request->users_rates;

                        for ($l=0; $l < count($arr); $l++) {
                            // echo $arr[$i]['name'];
                            if($arr[$l]['name'] == "user_id")
                            {
                                // echo $arr[$i]['name'];
                                // echo $arr[$l]['value'];
                                // echo "\n";
                                if($arr[$l]['value'] == $key)
                                {
                                    $j = $l;
                                    $j++;
                                    for ($k = 0; $k < 4; $k++) {
                                        // echo $arr[$j]['value'];
                                        // echo "\n";
                                        if($k == 0)
                                        $vbl1->job_rate = $arr[$j]['value'];
                                        if($k == 1)
                                        $vbl1->p_rate = $arr[$j]['value'];
                                        if($k == 2)
                                        $vbl1->sat_rate = $arr[$j]['value'];
                                        if($k == 3)
                                        $vbl1->sun_rate = $arr[$j]['value'];
                                        $j++;
                                    }
                                }
                            }
                        }
                        for ($l=0; $l < count($arr); $l++) {
                            // echo $arr[$i]['name'];
                            if($arr[$l]['name'] == "role_id")
                            {
                                // echo $arr[$i]['name'];
                                // echo $arr[$l]['value'];
                                // echo "\n";
                                if($arr[$l]['value'] == $request->users_role[$i])
                                {
                                    $j = $l;
                                    $j++;
                                    for ($k = 0; $k < 4; $k++) {
                                        // echo $arr[$j]['value'];
                                        // echo "\n";
                                        if($k == 0)
                                        $vbl1->c_charge_rate = $arr[$j]['value'];
                                        if($k == 1)
                                        $vbl1->c_p_rate = $arr[$j]['value'];
                                        if($k == 2)
                                        $vbl1->c_sat_rate = $arr[$j]['value'];
                                        if($k == 3)
                                        $vbl1->c_sun_rate = $arr[$j]['value'];
                                        $j++;
                                    }
                                }
                            }
                        }
                        // for ($k=0; $k < count($p_role_name); $k++) {
                        //     if($request->users_role[$i] == $p_role_name[$k])
                        //     {
                        //         $vbl1->job_rate = $p_role_price[$k];
                        //         break;
                        //     }
                        // }
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
            ->select('companies.c_name','jobs.*')
            ->first();

            // $date = str_replace('/', '-', $vbl->j_date);
            // $new_date = date('d/m/Y', strtotime($date));
            // $vbl->j_date = $new_date;

            array_push($job,$vbl);
            // return $vbl;


            $vbl2 = DB::table('job__users')
            ->where('job_id','=',$vbl->id)
            ->join('users','users.id','=','job__users.user_id')
            ->join('roles','roles.id','=','job__users.role_id')
            ->select('users.id','users.u_name','roles.id as role_id','roles.r_name','job__users.job_rate','job__users.p_rate','job__users.sat_rate','job__users.sun_rate','job__users.c_charge_rate','job__users.c_p_rate','job__users.c_sat_rate','job__users.c_sun_rate')
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

            // $date = str_replace('/', '-', $vbl9->j_date);
            // $new_date = date('d/m/Y', strtotime($date));
            // $vbl9->j_date = $new_date;

            // return $vbl9;

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
                'j_date'=> 'required|date_format:Y-m-d',
                // 'charge_rate'=> 'required|numeric',
                // 'charge_rate_ot'=> 'required|numeric',
                // 'p_end'=> 'required|date_format:H:i',
                // 'p_start'=> 'required|date_format:H:i',
                // 'p_rate'=> 'required|numeric',
                // 'sat_rate'=> 'required|numeric',
                // 'sun_rate'=> 'required|numeric',
            ],[
                'j_location.required' => 'Location is required.',
                'j_location.min' => 'Location must be of 5 characters.',
                'company_id.required' => 'Company ID is required.',
                'company_id.numeric' => 'Company ID should be numeric.',
                'j_date.required' => 'Date is required for Job to be submitted.',
                'j_date.date_format' => 'Incorrect date format. Format: DD/MM/YYYY.',
                // 'p_end.required'=> 'Penality End time is required.',
                // 'p_start.required'=> 'Penality Start time is required.',
                // 'p_end.date_format'=> 'Penality End time format is Incorrect.',
                // 'p_start.date_format'=> 'Penality Start time format is Incorrect.',
                // 'p_rate.required'=> 'Penality Rate is required.',
                // 'p_rate.numeric'=> 'Penality Rate must be numeric.',
                // 'sat_rate.required'=> 'Saturday Penality Rate is required.',
                // 'sat_rate.numeric'=> 'Saturday Penality Rate must be numeric.',
                // 'sun_rate.required'=> 'Sunday Penality Rate is required.',
                // 'sun_rate.numeric'=> 'Sunday Penality Rate must be numeric.',
                // 'charge_rate.required'=> 'Client Charge Rate is required.',
                // 'charge_rate.numeric'=> 'Client Charge Rate must be numeric.',
                // 'charge_rate_ot.required'=> 'Client Charge Rate (OT) is required.',
                // 'charge_rate_ot.numeric'=> 'Client Charge Rate (OT) must be numeric.',
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

                // return $request->j_date;
                // $date = str_replace('/', '-', $request->j_date);
                // $new_date = date('Y-m-d', strtotime($date));
                // $vbl->j_date = $new_date;

                $vbl->j_date = $request->j_date;
                // $vbl->charge_rate = $request->charge_rate;
                // $vbl->charge_rate_ot = $request->charge_rate_ot;
                $vbl->j_status = "ACTIVE";
                // $vbl->p_start = $request->p_start;
                // $vbl->p_end = $request->p_end;
                // $vbl->p_rate = $request->p_rate;
                // $vbl->sat_rate = $request->sat_rate;
                // $vbl->sun_rate = $request->sun_rate;
                $vbl->save();

                $vbl2 = Job_User::where('job_id',$request->job_id)->get();
                foreach ($vbl2 as $key ) {
                    $key->delete();
                }

                if($request->job_users == null || empty($request->job_users)){}
                else
                {
                    // $j=0;
                    // $p_role_name = array();
                    // $p_role_price = array();
                    // foreach ($request->roles_prices as $value) {
                    //     if($j % 2 == 0)
                    //     array_push($p_role_name,$value);
                    //     else
                    //     array_push($p_role_price,$value);
                    //     $j++;
                    // }
                    // return array($p_role_name,$p_role_price);

                    $i = 0;
                    foreach ($request->job_users as $key ) {
                        $vbl1 = new Job_User;
                        $vbl1->job_id = $vbl->id;
                        $vbl1->user_id = $key;
                        $vbl1->role_id = $request->users_role[$i];

                        $arr = $request->users_rates;

                        for ($l=0; $l < count($arr); $l++) {
                            // echo $arr[$i]['name'];
                            if($arr[$l]['name'] == "user_id")
                            {
                                // echo $arr[$i]['name'];
                                // echo $arr[$l]['value'];
                                // echo "\n";
                                if($arr[$l]['value'] == $key)
                                {
                                    $j = $l;
                                    $j++;
                                    for ($k = 0; $k < 4; $k++) {
                                        // echo $arr[$j]['value'];
                                        // echo "\n";
                                        if($k == 0)
                                        $vbl1->job_rate = $arr[$j]['value'];
                                        if($k == 1)
                                        $vbl1->p_rate = $arr[$j]['value'];
                                        if($k == 2)
                                        $vbl1->sat_rate = $arr[$j]['value'];
                                        if($k == 3)
                                        $vbl1->sun_rate = $arr[$j]['value'];
                                        $j++;
                                    }
                                }
                            }
                        }
                        for ($l=0; $l < count($arr); $l++) {
                            // echo $arr[$i]['name'];
                            if($arr[$l]['name'] == "role_id")
                            {
                                // echo $arr[$i]['name'];
                                // echo $arr[$l]['value'];
                                // echo "\n";
                                if($arr[$l]['value'] == $request->users_role[$i])
                                {
                                    $j = $l;
                                    $j++;
                                    for ($k = 0; $k < 4; $k++) {
                                        // echo $arr[$j]['value'];
                                        // echo "\n";
                                        if($k == 0)
                                        $vbl1->c_charge_rate = $arr[$j]['value'];
                                        if($k == 1)
                                        $vbl1->c_p_rate = $arr[$j]['value'];
                                        if($k == 2)
                                        $vbl1->c_sat_rate = $arr[$j]['value'];
                                        if($k == 3)
                                        $vbl1->c_sun_rate = $arr[$j]['value'];
                                        $j++;
                                    }
                                }
                            }
                        }
                        // for ($k=0; $k < count($p_role_name); $k++) {
                        //     if($request->users_role[$i] == $p_role_name[$k])
                        //     {
                        //         $vbl1->job_rate = $p_role_price[$k];
                        //         break;
                        //     }
                        // }
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

            DoneJob::where('job_id',$request->id)->delete();

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
        ->select('jobs.id','jobs.j_location','companies.c_contact','companies.c_name')
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
