<?php

namespace App\Http\Controllers;

use App\Models\DoneJob;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $verification->token = $token;
                $str['data']=$verification;
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

    public function submit_work(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'job_id'=>'required|exists:jobs,id',
        'user_id' => 'required|exists:users,id',
        'start' => 'required',
        'finish' => 'required',
        'break' => 'required|date_format:H:i',
        'supervisor' => 'required|min:3',
        'signature' => 'string',
        ], [
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
        else
        {
            $var = $request->break;
            // return $var;
            if($var == "00:45" || $var == "01:00" || $var == "01:15" ||
               $var == "01:30" || $var == "01:45" || $var == "02:00" || $var == "00:30" )
            {
                $vbl3 = Job::find($request->job_id);

                $curr_date = date('Y-m-d');
                $curr_date = strtotime($curr_date);

                $db_date = strtotime($vbl3->j_date);

                if($db_date <= $curr_date){}
                else
                {
                    $str['status']=false;
                    $str['message']="JOB NOT STARTED YET";
                    return $str;
                }


                $vbl4 = DB::table('job__users')
                ->where('job__users.job_id','=',$request->job_id)
                ->where('job__users.user_id','=',$request->user_id)
                ->select('job__users.role_id')
                ->first();

                // return $vbl4;

                $vbl = new DoneJob;
                $vbl->job_id = $request->job_id;
                $vbl->user_id = $request->user_id;
                $vbl->job_date = date('Y-m-d');
                $vbl->role_id = $vbl4->role_id;


                $eg1 = date('h:i A',strtotime($request->start));
                $eg2 = date('h:i A',strtotime($request->finish));

                $vbl->start = $eg1;
                $vbl->finish = $eg2;
                $vbl->break = $request->break;
                $vbl->supervisor = $request->supervisor;

                if($request->signature == null || $request->signature == "")
                {
                    $vbl->signature = "NO_SIGNATURE";
                }
                else
                {
                    $vbl->signature = $request->signature;
                }

                $vbl->save();

                $str['status']=true;
                $str['message']="USER WORK SUBMITTED";
                return $str;
            }
            else
            {
                $str['status']=false;
                $str['message']="ONLY GIVEN BREAK TIME ALLOWED";
                return $str;
            }



        }
    }

    public function get_curr(Request $request)
    {
        $vbl = User::find($request->user_id);

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="USER DOES NOT EXIST";
            return $str;
        }
        else
        {
            $today_date = date('Y-m-d');
            // $today_date = "2022-01-23";
            $today = date('D',strtotime($today_date));
            $days_dates = array();
            // return $today;

            if($today == 'Mon'){
                for ($i=0; $i < 1; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Tue'){
                for ($i=0; $i < 2; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Wed'){
                for ($i=0; $i < 3; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Thu'){
                for ($i=0; $i < 4; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Fri'){
                for ($i=0; $i < 5; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Sat'){
                for ($i=0; $i < 6; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Sun'){
                for ($i=0; $i < 7; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }

            // return $days_dates;

            // $time1 = strtotime('08:00 AM');
            // $time2 = strtotime('05:00 PM');
            // $difference = round(abs($time2 - $time1) / 3600,2);
            // return $difference;

            // $final_array = array();

            $vbl10 = array();
            for ($i=0; $i < count($days_dates); $i++) {
                // return $days_dates[$i];

                $vbl = DB::table('done_jobs')
                ->join('jobs','jobs.id','=','done_jobs.job_id')
                ->where('done_jobs.user_id','=',$request->user_id)
                ->where('done_jobs.job_date','=',$days_dates[$i])
                ->select('done_jobs.id as done_job_id','jobs.j_date','done_jobs.start','done_jobs.finish','done_jobs.break')
                ->first();

                // return $vbl;

                $day = date('D',strtotime($days_dates[$i]));


                if(empty($vbl))
                {
                    $grt['j_date']=$days_dates[$i];
                    $grt['done_job_id']=null;
                    $grt['start']=null;
                    $grt['finish']=null;
                    $grt['break']=null;
                    $grt['submission_status']=false;
                    $grt['working_day']=$day;
                    $grt['working_hours']=null;

                    // return $days_dates[$i];
                    // echo "hello2";
                    array_push($vbl10,$grt);
                }
                else
                {


                    $vbl->submission_status=true;

                    $time1 = strtotime($vbl->start);
                    $time2 = strtotime($vbl->finish);
                    $difference = round(abs($time2 - $time1) / 3600,2);

                    $var3 = $vbl->break;
                    if($var3 == "00:30")
                    $difference = $difference - 0.50;
                    if($var3 == "00:45")
                    $difference = $difference - 0.75;
                    if($var3 == "01:00")
                    $difference = $difference - 1.00;
                    if($var3 == "01:15")
                    $difference = $difference - 1.25;
                    if($var3 == "01:30")
                    $difference = $difference - 1.50;
                    if($var3 == "01:45")
                    $difference = $difference - 1.75;
                    if($var3 == "02:00")
                    $difference = $difference - 2.00;

                    $vbl->j_date=$days_dates[$i];
                    $vbl->working_day=$day;
                    $vbl->working_hours=$difference;
                    array_push($vbl10,$vbl);
                    // echo "hello";
                    // echo $vbl10[0]->done_job_id;
                }

                // array_push($final_array,$vbl2);

                // $vbl2 = null;
            }

            $str['status']=true;
            $str['message']="WORK SUBMISSION SHOWN FOR THE CURRENT WEEK";
            $str['data']=$vbl10;

            return $str;
        }
    }

    public function get_prev(Request $request)
    {
        $vbl = User::find($request->user_id);

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="USER DOES NOT EXIST";
            return $str;
        }
        else
        {
            $today_date = date('Y-m-d');
            // $today_date = "2022-01-24";
            $today = date('D',strtotime($today_date));
            // return $today;
            $days_dates = array();
            // return $today;

            if($today == 'Mon'){
                for ($i=1; $i < 8; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Tue'){
                for ($i=2; $i < 9; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Wed'){
                for ($i=3; $i < 10; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Thu'){
                for ($i=4; $i < 11; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Fri'){
                for ($i=5; $i < 12; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Sat'){
                for ($i=6; $i < 13; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            if($today == 'Sun'){
                for ($i=7; $i < 14; $i++) {
                    $prev = date('Y-m-d', strtotime($today_date. '-'.$i.'days'));
                    array_unshift($days_dates,$prev);
                }
            }
            // return $days_dates;

            // $final_array = array();

            $vbl10 = array();
            for ($i=0; $i < count($days_dates); $i++) {
                // echo $days_dates[$i];

                $vbl = DB::table('done_jobs')
                ->join('jobs','jobs.id','=','done_jobs.job_id')
                ->where('done_jobs.user_id','=',$request->user_id)
                ->where('done_jobs.job_date','=',$days_dates[$i])
                ->select('done_jobs.id as done_job_id','jobs.j_date','done_jobs.start','done_jobs.finish','done_jobs.break')
                ->first();

                $day = date('D',strtotime($days_dates[$i]));

                if(empty($vbl))
                {
                    $grt['j_date']=$days_dates[$i];
                    $grt['done_job_id']=null;
                    $grt['start']=null;
                    $grt['finish']=null;
                    $grt['break']=null;
                    $grt['submission_status']=false;
                    $grt['working_day']=$day;
                    $grt['working_hours']=null;

                    array_push($vbl10,$grt);
                }
                else
                {
                    $vbl->submission_status=true;

                    $time1 = strtotime($vbl->start);
                    $time2 = strtotime($vbl->finish);
                    $difference = round(abs($time2 - $time1) / 3600,2);

                    $var3 = $vbl->break;
                    if($var3 == "00:30")
                    $difference = $difference - 0.50;
                    if($var3 == "00:45")
                    $difference = $difference - 0.75;
                    if($var3 == "01:00")
                    $difference = $difference - 1.00;
                    if($var3 == "01:15")
                    $difference = $difference - 1.25;
                    if($var3 == "01:30")
                    $difference = $difference - 1.50;
                    if($var3 == "01:45")
                    $difference = $difference - 1.75;
                    if($var3 == "02:00")
                    $difference = $difference - 2.00;

                    $vbl->j_date=$days_dates[$i];
                    $vbl->working_day=$day;
                    $vbl->working_hours=$difference;
                    array_push($vbl10,$vbl);
                }

                // array_push($final_array,$vbl2);

                // $vbl2 = null;
            }

            $str['status']=true;
            $str['message']="WORK SUBMISSION SHOWN FOR THE PREVIOUS WEEK";
            $str['data']=$vbl10;

            return $str;
        }
    }

    public function today_jobs(Request $request)
    {
        $vbl = User::find($request->user_id);

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="USER DOES NOT EXIST";
            return $str;
        }
        else
        {
            $vbl1 = DB::table('job__users')
            ->where('user_id','=',$request->user_id)
            ->join('jobs','jobs.id','=','job__users.job_id')
            // ->where('j_date','=',date('Y-m-d'))
            // ->where('j_status','=',"ACTIVE")
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('jobs.j_date','job__users.job_id','job__users.user_id','companies.c_contact','jobs.j_location')
            ->get();

            // return $vbl1;

            $final_array = array();
            foreach ($vbl1 as $value) {
                // echo "HELLO";
                // echo $value->j_date;
                $curr_date = date('Y-m-d');
                $curr_date = strtotime($curr_date);

                $db_date = strtotime($value->j_date);
                if($db_date <= $curr_date)
                {
                    // echo $value->j_date;
                    array_push($final_array,$value);
                }
            }

            if(count($vbl1) == 0)
            {
                $str['status']=false;
                $str['message']="NO JOBS FOUND FOR TODAY";
                return $str;
            }
            else
            {
                $str['status']=true;
                $str['message']="JOBS SHOWN FOR TODAY";
                $str['data']=$final_array;
                return $str;
            }
        }
    }

    public function job_details(Request $request)
    {
        // return $request;
        $vbl = DB::table('jobs')
        ->where('jobs.id','=',$request->job_id)
        ->join('companies','companies.id','=','jobs.company_id')
        ->select('jobs.id as job_id','jobs.j_location','jobs.j_date','companies.c_name','companies.c_contact','companies.c_phone')
        ->first();

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="NO JOB FOUND FOR THIS JOB ID";
            return $str;
        }
        else
        {
            $str['status']=true;
            $str['message']="JOB SHOWN FOR GIVEN JOB ID";
            $str['data']=$vbl;
            return $str;
        }

    }

    public function job_done_details(Request $request)
    {
        // return $request;

        $vbl = DB::table('done_jobs')
        ->where('done_jobs.id','=',$request->done_job_id)
        ->join('jobs','jobs.id','=','done_jobs.job_id')
        ->join('companies','companies.id','=','jobs.company_id')
        ->select('jobs.j_date','jobs.j_location','companies.c_contact','done_jobs.*')
        ->first();

        if(empty($vbl))
        {
            $str['status']=false;
            $str['message']="NO DONE JOB FOUND FOR THIS ID";
            return $str;
        }
        else
        {
            $time1 = strtotime($vbl->start);
            $time2 = strtotime($vbl->finish);
            $difference = round(abs($time2 - $time1) / 3600,2);

            $var3 = $vbl->break;
            if($var3 == "00:30")
            $difference = $difference - 0.50;
            if($var3 == "00:45")
            $difference = $difference - 0.75;
            if($var3 == "01:00")
            $difference = $difference - 1.00;
            if($var3 == "01:15")
            $difference = $difference - 1.25;
            if($var3 == "01:30")
            $difference = $difference - 1.50;
            if($var3 == "01:45")
            $difference = $difference - 1.75;
            if($var3 == "02:00")
            $difference = $difference - 2.00;
            $vbl->working_hours=$difference;

            $str['status']=true;
            $str['message']="DONE JOB SHOWN FOR THIS ID";
            $str['data']=$vbl;
            return $str;
        }
    }
}
