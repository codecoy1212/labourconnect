<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DoneJob;
use App\Models\Job;
use App\Models\Job_User;
use App\Models\Role;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class MainController extends Controller
{
    public function index()
    {
        if(session()->get('s_uname'))
        {
            return view('main.dashboard');
        }
        else
            return redirect('login');

    }

    public function jobs()
    {
        if(session()->get('s_uname'))
        {
            $vbl4 = Job::where('j_status',"INACTIVE")->get();
            $vbl4 = count($vbl4);

            return view('main.jobs',compact('vbl4'));
        }
        else
            return redirect('login');

    }

    public function new_job()
    {
        if(session()->get('s_uname'))
        {
            $vbl = Company::all();

            $vbl3 = Role::all();

            $vbl2 = DB::table('jobs')->orderBy('id', 'desc')
            ->first();

            if(empty($vbl2))
            $vbl2 = 1;
            else
            $vbl2 = $vbl2->id+1;
            return view('main.main2.new_job',compact('vbl','vbl2','vbl3'));
        }
        else
            return redirect('login');
    }

    public function users()
    {
        if(session()->get('s_uname'))
        {
            $vbl = Role::all();

            return view('main.user',compact('vbl'));
        }
        else
            return redirect('login');
    }

    public function companies()
    {
        if(session()->get('s_uname'))
        {
            return view('main.companies');
        }
        else
            return redirect('login');
    }

    public function roles()
    {
        if(session()->get('s_uname'))
        {
            return view('main.roles');
        }
        else
            return redirect('login');

    }

    public function reports()
    {
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('jobs')
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('companies.c_contact','jobs.*')
            ->get();
            // return $vbl;

            return view('main.reports',compact('vbl'));
        }
        else
            return redirect('login');

    }

    public function show_pdf(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;

            $final = array();
            $main_detail = array();
            $second_detail = array();


            // return "hello";

            $start = $request->start_date;
            // echo $start = date('Y-m-d', strtotime($start. ' +1 day'));
            $ending = $request->end_date;

            $begin = new DateTime($start);
            $end = new DateTime($ending);
            $end->modify('+1 day');

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $job_id = $request->job_id;
            // return $job_id;
            // $vbl1 = Job::find($job_id);
            $vbl1 = DB::table('jobs')
            ->where('jobs.id','=',$job_id)
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('jobs.id','jobs.j_location','companies.c_contact')
            ->first();
            // return $vbl1;
            // echo $vbl1->c_contact."<br>";
            // echo $vbl1->j_location."<br>";
            // echo "<br>";


            array_push($main_detail,$vbl1->c_contact);
            array_push($main_detail,$vbl1->j_location);
            array_push($main_detail,$start);
            array_push($main_detail,$ending);

            array_push($final,$main_detail);
            // return $final;

            // $vbl2 = Job_User::where('job_id',$vbl1->id)->get();
            $vbl2 = DB::table('job__users')
            ->where('job_id','=',$vbl1->id)
            ->join('users','users.id','=','job__users.user_id')
            ->select('users.*')
            ->get();
            // return $vbl2;


            $total_hours = array();
            foreach ($vbl2 as $value) {
                $week= array();
                // echo "<b>".."</b><br><br>";
                array_push($second_detail,$value->u_name);
                foreach ($period as $dt) {
                    $day= array();
                    // echo format("l")."<br>";
                    $vbl13 = $dt->format("l");
                    $vbl5 = $dt->format("Y-m-d");
                    array_push($day,$vbl5);
                    array_push($day,$vbl13);
                    // echo $value->id;
                    // echo $vbl5;

                    // $vbl6 = DoneJob::where('user_id',$value->id)
                    // ->where('job_date',$vbl5)->first();
                    $vbl6 = DB::table('done_jobs')
                    ->where('user_id',$job_id)
                    ->where('user_id',$value->id)
                    ->where('job_date',$vbl5)
                    ->join('roles','roles.id','=','done_jobs.role_id')
                    ->select('done_jobs.*','roles.r_name')
                    ->first();

                    if(!empty($vbl6))
                    {
                        $time1 = strtotime($vbl6->start);
                        $time2 = strtotime($vbl6->finish);
                        $difference = round(abs($time2 - $time1) / 3600,2);

                        $var3 = $vbl6->break;
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

                        // echo $difference."<br>";
                        // echo $vbl6->r_name."<br>";

                        array_push($day,$difference);
                        array_push($day,$vbl6->r_name);

                        if($vbl6->signature != "NO_SIGNATURE")
                        {
                            // echo "YES"."<br><br>";
                            array_push($day,"YES");
                        }

                        else
                        {
                            // echo "NO_SIGNATURE"."<br><br>";
                            array_push($day,"NO");
                        }
                        $total_hours[$vbl6->r_name][] = $difference;


                    }
                    else
                    {
                        array_push($day,"NULL");
                        array_push($day,"NULL");
                        array_push($day,"NULL");
                    }
                    array_push($week,$day);
                }

                array_push($second_detail,$week);

                $third_detail = array();

                $total_gg = 0;
                $fourth_detail = array();
                foreach ($total_hours as $key => $value) {
                    // echo $key;
                    array_push($fourth_detail,$key);
                    for ($i=0; $i < count($value); $i++) {
                        $total_gg = $value[$i] + $total_gg;
                    }
                    // echo $total_gg;
                    array_push($fourth_detail,$total_gg);

                    array_push($third_detail,$fourth_detail);
                    $fourth_detail = array();
                    $total_gg = 0;
                }

                array_push($second_detail,$third_detail);
                array_push($final,$second_detail);
                $total_hours = array();
                // echo "<br>";
                $second_detail = array();
            }

            // return $final;

            return view('main.main2.report_pdf',compact('final'));
        }
        else
            return redirect('login');
    }
}
