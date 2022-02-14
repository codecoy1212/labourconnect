<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\Company;
use App\Models\DoneJob;
use App\Models\Job;
use App\Models\Job_User;
use App\Models\Role;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Else_;
use stdClass;

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
                    ->where('job_id',$job_id)
                    ->where('user_id',$value->id)
                    ->where('job_date',$vbl5)
                    ->join('roles','roles.id','=','done_jobs.role_id')
                    ->select('done_jobs.*','roles.r_name')
                    ->first();

                    if(!empty($vbl6))
                    {
                        $time1 = strtotime($vbl6->start);
                        $time2 = strtotime($vbl6->finish);

                        $time_1 = date('Y-m-d h:i:s A',strtotime($vbl6->job_date.$vbl6->start));
                        // echo $time_1."<br>";
                        // return $ls;
                        if($time1 < $time2 )
                        {
                            $time_2 = date('Y-m-d h:i:s A',strtotime($vbl6->job_date.$vbl6->finish));
                            // echo $time_2."<br>";
                        }
                        else
                        {
                            $time_2 = date('Y-m-d h:i:s A',strtotime($vbl6->job_date.$vbl6->finish.' +1 day'));
                            // echo $time_2."<br>";
                            // return $time_2;
                            // $next_day_start
                            // $next_day_end
                        }

                        $start = strtotime($time_1);
                        $end = strtotime($time_2);

                        $difference = round(abs($end - $start) / 3600,2);

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
                        array_push($day,"-");
                        array_push($day,"-");
                        array_push($day,"-");
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

    public static function show_csv(Request $request)
    {
        // return Job::all();

        if(session()->get('s_uname'))
        {
            // return $request->start_date;

            $client = DB::table('jobs')
            ->where('jobs.id','=',$request->job_id)
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('companies.c_contact','jobs.*')
            ->first();
            // return $client;

            $day2 = date('w',strtotime($request->start_date));
            $day3 = date('w',strtotime($request->end_date));
            //week start of month first date
            $week_start = date('Y-m-d', strtotime($request->start_date.'-'.(-1+$day2).' days'));
            //week end of month last date
            $week_end = date('Y-m-d', strtotime($request->end_date.'+'.(7-$day3).' days'));

            $start = $week_start;
            $ending = $week_end;
            $begin = new DateTime($start);
            $end = new DateTime($ending);
            $end->format("Y-m-d")."<br>";
            $end->modify('+1 day');
            $end->format("Y-m-d")."<br>";

            $interval = DateInterval::createFromDateString('7 day');
            $period = new DatePeriod($begin, $interval, $end);

            $candidate = DB::table('job__users')
            ->where('job_id','=',$request->job_id)
            ->join('users','users.id','=','job__users.user_id')
            ->join("roles","roles.id","=","job__users.role_id")
            ->select('users.*',"roles.r_name",'job__users.job_rate')
            ->get();

            // return $candidate;

            $final_array_final = array();
            foreach ($candidate as $item) {

                $total_normal_hours_final = 0;
                $total_over_hours_final = 0;
                $sat_ot_total = "-";
                $sun_ot_total = "-";
                foreach ($period as $dt) {
                    // echo "<br>";
                    // echo date("W Y-m-d",strtotime($request->start_date));
                    // echo "Client: ".$client->c_contact."<br>";
                    // echo "Site: ".$client->j_location."<br>";
                    // echo "Week Start Date: ".$dt->format("W Y-m-d")."<br>";
                    // echo "Week End Date: ".date('W Y-m-d',strtotime($dt->format("Y-m-d").' +6 day'))."<br>";
                    // echo "Candidate: ".$item->u_name."<br>";
                    // echo "Job Role: ".$item->r_name."<br>";
                    // echo "<br>";
                    $final_result = new stdClass;
                    $final_result->client = $client->c_contact;
                    $final_result->site = $client->j_location;
                    $final_result->Week_start_date = $dt->format("Y-m-d");
                    $final_result->week_end_date = date('Y-m-d',strtotime($dt->format("Y-m-d").' +6 day'));
                    $final_result->candidate = $item->u_name;
                    $final_result->job_role = $item->r_name;

                    $start_day = $dt->format("Y-m-d");
                    $end_day = new DateTime($dt->format("Y-m-d"));
                    $end_day->modify('+7 day');
                    $start_day_final = new DateTime($start_day);
                    $end_day_final = new DateTime($end_day->format("Y-m-d"));

                    $interval2 = DateInterval::createFromDateString('1 day');
                    $period2 = new DatePeriod($start_day_final,$interval2,$end_day_final);


                    $nh_list = array();
                    $oh_list = array();
                    foreach ($period2 as $dt2) {
                        // echo "HELLO"."<br>";
                        // echo $dt2->format("l Y-m-d")."<br>";
                        $today_day = $dt2->format("l");
                        $dattte = $dt2->format("Y-m-d");

                        // $vbl7 = DoneJob::where('job_date',$dattte)
                        // ->where('user_id',$item->id)->first();

                        $vbl7 = DB::table('done_jobs')
                        ->where('job_date',$dattte)
                        ->where('user_id',"=",$item->id)
                        ->select("done_jobs.*")
                        ->first();

                        // return $vbl7;

                        if(!empty($vbl7))
                        {
                            // echo $vbl7->job_rate."<br>";

                            $time1 = strtotime($vbl7->start);
                            // echo $time1."<br>";
                            $time2 = strtotime($vbl7->finish);
                            // echo $time2."<br>";

                            $time_1 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->start));
                            // echo $time_1."<br>";
                            $ls = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."07:00:00 AM"));
                            $le = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."05:00:00 PM"));
                            $ls = strtotime($ls);
                            $le = strtotime($le);
                            $next_day_start = 0;
                            $next_day_end = 0;
                            // return $ls;
                            if($time1 < $time2 )
                            {
                                $time_2 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->finish));
                                // echo $time_2."<br>";
                            }
                            else
                            {
                                $time_2 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->finish.' +1 day'));
                                // echo $time_2."<br>";
                                $next_day_start = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."07:00:00 AM".' +1 day'));
                                $next_day_start = strtotime($next_day_start);
                                $next_day_end = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."05:00:00 PM".' +1 day'));
                                $next_day_end = strtotime($next_day_end);
                                // return $time_2;
                                // $next_day_start
                                // $next_day_end
                            }

                            $start = strtotime($time_1);
                            $end = strtotime($time_2);

                            // echo $today_day = "Sunday";
                            if($today_day == "Sunday" )
                            {
                                // echo "Sunday Overtime <br>";
                                $end = $end-$start;
                                $end = $end/3600;
                                $difference = $end;
                                $var3 = $vbl7->break;
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

                                $sun_ot_total = $difference;
                            }

                            else if($today_day == "Saturday" )
                            {
                                // echo "Saturday Overtime <br>";
                                $end = $end-$start;
                                $end = $end/3600;
                                $difference = $end;
                                $var3 = $vbl7->break;
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

                                $sat_ot_total = $difference;
                            }

                            else
                            {
                                $final_normal_hours = "-";
                                $final_over_hours = "-";


                                if($time1 == $time2)
                                {
                                    // echo "SAME TIMING GIVEN";
                                    return "SAME TIME GIVEN IN SUBMISSION OF WORK";
                                }
                                else if($time1 > $time2)
                                {
                                    if($start >= $le && $end >= $le && $end <= $next_day_start )
                                    {
                                        // echo "CON 7<br>";
                                      $vbl = $end-$start;
                                    //   echo "Over Hours: ". $vbl;
                                    //   echo "<br>";
                                    //   echo "Normal Hours: ". 0;
                                    //   echo "<br>";
                                      $final_normal_hours = 0;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start >= $le && $end >= $le && $end >= $next_day_start && $end <= $next_day_end)
                                    {
                                        // echo "CON 8<br>";
                                      $vbl = $next_day_start-$start;
                                    //   echo "Over Hours: ". $vbl;
                                      $vbl2 = $end-$next_day_start;
                                    //   echo "<br>";
                                    //   echo "Normal Hours: ". $vbl2;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl2;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start >= $le && $end >= $le && $end >=$next_day_start && $end >= $next_day_end)
                                    {
                                        // echo "CON 9<br>";
                                      $vbl = $next_day_start-$start;
                                      $vbl3 = $next_day_end-$next_day_start;
                                    //   echo "Normal Hours: ". $vbl3;
                                      $vbl2 = $end-$next_day_end;
                                      $vbl2 = $vbl2+$vbl;
                                    //   echo "<br>";
                                    //   echo "Over Hours: ". $vbl2;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl3;
                                      $final_over_hours = $vbl2;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start <= $le && $start >= $ls && $end <= $next_day_start)
                                    {
                                        // echo "CON 10<br>";
                                      $vbl = $le-$start;
                                      $vbl3 = $end-$le;
                                    //   echo "Normal Hours: ". $vbl;
                                    //   echo "<br>";
                                    //   echo "Over Hours: ". $vbl3;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl;
                                      $final_over_hours = $vbl3;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start <= $ls && $end <= $next_day_start)
                                    {
                                        // echo "CON 11<br>";
                                      $vbl = $ls-$start;
                                      $vbl3 = $le-$ls;
                                    //   echo "Normal Hours: ". $vbl3;
                                      $vbl2 = $end-$le;
                                      $vbl2 = $vbl2+$vbl;
                                    //   echo "<br>";
                                    //   echo "Over Hours: ". $vbl2;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl3;
                                      $final_over_hours = $vbl2;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start >= $ls && $start <= $le && $end >= $next_day_start  && $end <= $next_day_end)
                                    {
                                        // echo "CON 12<br>";
                                      $vbl = $le-$start;
                                      $vbl3 = $next_day_start-$le;

                                      $vbl2 = $end-$next_day_start;
                                      $vbl2 = $vbl2+$vbl;
                                    //   echo "Normal Hours: ". $vbl2;
                                    //   echo "<br>";
                                    //   echo "Over Hours: ". $vbl3;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl2;
                                      $final_over_hours = $vbl3;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }
                                }
                                else if($time1 < $time2)
                                {
                                    if($start >= $ls && $start <= $le && $end >= $ls && $end <= $le)
                                    {
                                    //     echo "CON 1<br>";
                                    //   echo "Over Hours: ". 0;
                                    //   echo "<br>";
                                      $vbl = $end-$start;
                                    //   echo "Normal Hours: ".$vbl;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl;
                                      $final_over_hours = 0;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start <= $ls && $start <= $le && $end <= $ls && $end <= $le)
                                    {
                                    //   echo "CON 2<br>";
                                      $vbl = $end-$start;
                                    //   echo "Over Hours: ". $vbl;
                                    //   echo "<br>";
                                    //   echo "Normal Hours: ". 0;
                                    //   echo "<br>";
                                      $final_normal_hours = 0;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start >= $ls && $start >= $le && $end >= $ls && $end >= $le)
                                    {
                                        // echo "CON 3<br>";
                                      $vbl = $end-$start;
                                    //   echo "Over Hours: ". $vbl;
                                    //   echo "<br>";
                                    //   echo "Normal Hours: ". 0;
                                    //   echo "<br>";
                                      $final_normal_hours = 0;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start >= $ls && $start <= $le && $end >= $ls && $end >= $le)
                                    {
                                        // echo "CON 4<br>";
                                      $vbl = $le-$start;
                                      $vbl2 = $end-$le;
                                    //   echo "Over Hours: ". $vbl2;
                                    //   echo "<br>";
                                    //   echo "Normal Hours: ". $vbl;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl;
                                      $final_over_hours = $vbl2;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start <= $ls && $start <= $le && $end >= $ls && $end <= $le)
                                    {
                                        // echo "CON 5<br>";
                                      $vbl = $ls-$start;
                                    //   echo "Over Hours: ". $vbl;
                                    //   echo "<br>";
                                      $vbl2 = $end-$ls;
                                    //   echo "Normal Hours: ". $vbl2;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl2;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }

                                    else if($start <= $ls && $start <= $le && $end >= $ls && $end >= $le)
                                    {
                                        // echo "CON 6<br>";
                                      $vbl = $ls-$start;
                                      $vbl3 = $end-$le;
                                      $vbl = $vbl+$vbl3;
                                    //   echo "Over Hours: ". $vbl;
                                    //   echo "<br>";
                                      $vbl2 = $le-$ls;
                                    //   echo "Normal Hours: ". $vbl2;
                                    //   echo "<br>";
                                      $final_normal_hours = $vbl2;
                                      $final_over_hours = $vbl;
                                      $eg1 = $final_normal_hours/3600;
                                      $eg2 = $final_over_hours/3600;
                                      array_push($nh_list,$eg1);
                                      array_push($oh_list,$eg2);
                                    }
                                }

                                $final_normal_hours = $final_normal_hours/3600;
                                $final_over_hours = $final_over_hours/3600;

                                // echo "Normal Hours: ".$final_normal_hours."<br>";
                                // echo "Over Hours: ".$final_over_hours."<br>";

                                // $difference = round(abs($time2 - $time1) / 3600,2);
                                // echo $difference."<br>";

                                if($final_normal_hours >= $final_over_hours)
                                {
                                  $difference = $final_normal_hours;
                                  $var3 = $vbl7->break;
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

                                  $working_hours = $difference;
                                //   echo "Normal Hours: ".$working_hours."<br>";
                                //   echo "Over Hours: ".$final_over_hours."<br>";
                                  $total_normal_hours_final = $working_hours + $total_normal_hours_final;
                                  $total_over_hours_final = $final_over_hours + $total_over_hours_final;
                                }
                                else
                                {
                                  $difference = $final_over_hours;
                                  $var3 = $vbl7->break;
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

                                //   echo "Normal Hours: ".$final_normal_hours."<br>";
                                  $working_hours = $difference;
                                //   echo "Over Hours: ".$working_hours."<br>";
                                  $total_normal_hours_final = $final_normal_hours + $total_normal_hours_final;
                                  $total_over_hours_final = $working_hours + $total_over_hours_final;
                                }
                            }
                        }
                        else
                        {
                            // $null= 0;
                            // echo $null."<br>";
                            array_push($nh_list,"");
                            array_push($oh_list,"");
                        }
                    }
                    // echo "Standards Hours Total: ".$total_normal_hours_final."<br>";
                    // echo "Overtime Hours Total: ".$total_over_hours_final."<br>";
                    // echo "Saturday Overtime Hours: ".$sat_ot_total."<br>";
                    // echo "Sunday Overtime Hours: ".$sun_ot_total."<br>";
                    // echo "Standard Rate: ".$item->job_rate."<br>";
                    // echo "Penality Rate: ".$client->p_rate."<br>";
                    // echo "Saturday Penality Rate: ".$client->sat_rate."<br>";
                    // echo "Sunday Penality Rate: ".$client->sun_rate."<br>";
                    // echo "<br><br>";

                    // return $oh_list;
                    // return $nh_list;

                    if(!empty($nh_list[0]))
                    $final_result->Mon = $nh_list[0];
                    else
                    $final_result->Mon = "-";

                    if(!empty($nh_list[1]))
                    $final_result->Tue = $nh_list[1];
                    else
                    $final_result->Tue = "-";

                    if(!empty($nh_list[2]))
                    $final_result->Wed = $nh_list[2];
                    else
                    $final_result->Wed = "-";

                    if(!empty($nh_list[3]))
                    $final_result->Thu = $nh_list[3];
                    else
                    $final_result->Thu = "-";

                    if(!empty($nh_list[4]))
                    $final_result->Fri = $nh_list[4];
                    else
                    $final_result->Fri = "-";


                    if($total_normal_hours_final == 0)
                    $final_result->standard_hours_total = "-";
                    else
                    $final_result->standard_hours_total = $total_normal_hours_final;



                    if(!empty($oh_list[0]))
                    $final_result->Mon_OT = $oh_list[0];
                    else
                    $final_result->Mon_OT = "-";

                    if(!empty($oh_list[1]))
                    $final_result->Tue_OT = $oh_list[1];
                    else
                    $final_result->Tue_OT = "-";

                    if(!empty($oh_list[2]))
                    $final_result->Wed_OT = $oh_list[2];
                    else
                    $final_result->Wed_OT = "-";

                    if(!empty($oh_list[3]))
                    $final_result->Thu_OT = $oh_list[3];
                    else
                    $final_result->Thu_OT = "-";

                    if(!empty($oh_list[4]))
                    $final_result->Fri_OT = $oh_list[4];
                    else
                    $final_result->Fri_OT = "-";


                    if($total_over_hours_final == 0)
                    $final_result->overtime_hours_total = "-";
                    else
                    $final_result->overtime_hours_total = $total_over_hours_final;



                    $final_result->saturday_overtime_hours = $sat_ot_total;
                    $final_result->sunday_overtime_hours = $sun_ot_total;
                    $int = (int)$item->job_rate;
                    $final_result->standard_rate = $int;
                    $final_result->penality_rate = $client->p_rate;
                    $final_result->saturday_penality = $client->sat_rate;
                    $final_result->sunday_penality = $client->sun_rate;

                    array_push($final_array_final,$final_result);
                    $final_result = "";
                    $total_normal_hours_final = 0;
                    $total_over_hours_final = 0;
                    $sat_ot_total = "";
                    $sun_ot_total = "";
                }
            }
            return $final_array_final;
        }
        else
            return redirect('login');
    }

    public function export_csv()
    {
        if(session()->get('s_uname'))
        {
            //pls try
            return Excel::download(new UserExport,'LabourConnect.xlsx');
        }
        else
            return redirect('login');
    }
}
