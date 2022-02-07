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



    // public static function show_csv(Request $request)
    // {
    //     // return $request;

    //     // $time1 = strtotime($vbl7->start);
    //     // echo $time1."<br>";
    //     // $time2 = strtotime($vbl7->finish);
    //     // echo $time2."<br>";

    //     $php1 = '2022-02-05 09:00:00 PM';
    //     $php2 = '2022-02-06 08:59:00 PM';

    //     $php1 = strtotime($php1);
    //     echo $php1."<br>";
    //     $php2 = strtotime($php2);
    //     echo $php2."<br>";
    //     $php2 = $php2 - $php1;
    //     echo $php2."<br><br>";

    //     $time5 = strtotime("12:00 AM");
    //     echo $time5."<br>";
    //     $time4 = strtotime("07:00 AM");
    //     echo $time4."<br>";
    //     $time3 = strtotime("05:00 PM");
    //     echo $time3."<br>";
    //     $time6 = strtotime("01:00 AM");
    //     echo $time6."<br>";
    // }

    // public static function show_csv()
    public static function show_csv(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request->start_date;

            $client = DB::table('jobs')
            ->where('jobs.id','=',$request->job_id)
            ->join('companies','companies.id','=','jobs.company_id')
            ->select('companies.c_contact','jobs.j_location')
            ->first();
            // return $client;

            $day2 = date('w',strtotime($request->start_date));
            $day3 = date('w',strtotime($request->end_date));
            //week start of month first date
            $week_start = date('Y-m-d', strtotime($request->start_date.'-'.($day2).' days'));
            //week end of month last date
            $week_end = date('Y-m-d', strtotime($request->end_date.'+'.(6-$day3).' days'));

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
            ->select('users.*')
            ->get();

            foreach ($candidate as $item) {
                    echo "<br>";
                    echo $item->u_name;
                foreach ($period as $dt) {
                    echo "<br>";
                    // echo date("W Y-m-d",strtotime($request->start_date));
                    echo $client->c_contact."<br>";
                    echo $dt->format("W Y-m-d")."<br>";
                    echo $client->j_location."<br><br>";

                    $start_day = $dt->format("Y-m-d");
                    $end_day = new DateTime($dt->format("Y-m-d"));
                    $end_day->modify('+7 day');
                    $start_day_final = new DateTime($start_day);
                    $end_day_final = new DateTime($end_day->format("Y-m-d"));

                    $interval2 = DateInterval::createFromDateString('1 day');
                    $period2 = new DatePeriod($start_day_final,$interval2,$end_day_final);

                    // $total_hours = 0;
                    // $w_hours = 0;
                    // $o_hours = 0;
                    foreach ($period2 as $dt2) {
                        // echo "HELLO"."<br>";
                        // echo $dt2->format("Y-m-d")."<br>";
                        $dattte = $dt2->format("Y-m-d");

                        $vbl7 = DoneJob::where('job_date',$dattte)
                        ->where('user_id',$item->id)->first();

                        if(!empty($vbl7))
                        {
                            // echo $vbl7->job_rate."<br>";

                            $time1 = strtotime($vbl7->start);
                            // echo $time1."<br>";
                            $time2 = strtotime($vbl7->finish);
                            // echo $time2."<br>";

                            $vbl34 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->start));
                            // echo $vbl34."<br>";
                            if($time1 < $time2 )
                            {
                                $time2 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->finish));
                                // echo $time2."<br>";
                            }
                            else
                            {
                                $time2 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date.$vbl7->finish.' +1 day'));
                                // echo $time2."<br>";
                            }

                            $time_1 = strtotime($vbl34);
                            $time_2 = strtotime($time2);
                            echo $time_1."<br>";
                            echo $time_2."<br>";

                            $time4 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."07:00:00 AM"));
                            $time4 = strtotime($time4);
                            echo $time4."<br>";
                            $time3 = date('Y-m-d h:i:s A',strtotime($vbl7->job_date."05:00:00 PM"));
                            $time3 = strtotime($time3);
                            echo $time3."<br>";



                            // if($time_1 <= $time3 && $time_1 >= $time4 && $time_2 <= $time3 && $time_2 >= $time4 )
                            // {
                            //     echo "START TIME SUBAH 7 K BAD OR END TIME SHAM 5 SE PEHLE<br>";
                            // }
                            // else if($time_1 >= $time3 && $time_1 >= $time4 && $time_2 <= $time3 && $time_2 >= $time4 )
                            // {
                            //     echo "START TIME SUBAH 7 K BAD OR END TIME SHAM 5 SE PEHLE<br>";
                            // }
                            // else if($time_1 >= $time3 && $time_2 <= $time4 && $time_1 <= $time6 && $time_2 >= $time5 && $time_2 <=$time4)
                            // {
                            //     echo "START TIME SHAM 5 K BAD OR RAT 12 SE PEHLE END TIME SUBAH 7 SE PEHLE OR RAT 12 K BAD<br>";
                            // }
                            // else if($time_1 >= $time5 && $time_1 <= $time4 && $time_2 >= $time4 && $time_2 >= $time3 )
                            // {
                            //     echo "START TIME SUBAH 7 SE PEHLE END TIME SHAM 5 BJE K BAD OR RAT 12 SE PEHLE <br>";
                            // }
                            // else if($time_1 >= $time5 && $time_1 <= $time4 && $time_2 >= $time4 && $time_2 <= $time3 )
                            // {
                            //     echo "START TIME RAT 12 BJE K BAD OR END TIME SHAM 5 SE PEHLE<br>";
                            // }
                            // else if($time_1 >= $time4 && $time_1 <= $time3 && $time_2 >= $time3 && $time_2 <= $time6)
                            // {
                            //     echo "START TIME SUBAH 7 K BAD OR SHAM 5 SE PEHLE OR END TIME RAT 12 BJE SE PEHLE OR SHAM 5 BJE K BAD <br>";
                            // }
                            // else if($time_1 >= $time4 && $time_1 <= $time3 && $time_2 <= $time4)
                            // {
                            //     echo "START TIME SUBAH 7 K BAD OR SHAM 5 SE PEHLE OR END TIME RAT 12 K BAD OR SUBAH 7 SE PEHLE<br>";
                            // }
                            // else if($time_1 >= $time3 && $time_1 <= $time6 && $time_2 >= $time4)
                            // {
                            //     echo "START TIME SHAM 5 BJE K BAD OR END TIME SUBAH 7 BJE K BAD<br>";
                            // }
                            // else if($time_1 >= $time5 && $time_1 <= $time4 && $time_2 >= $time5 && $time_2 <= $time4)
                            // {
                            //     echo "START TIME RAT 12 K BAD OR SUBAH 7 SE PEHLE END TIME RAT 12 K BAD OR SUBAH 7 SE PEHLE<br>";
                            // }

                            $time1 = strtotime($vbl34);
                            $time2 = strtotime($time2);


                            $difference = round(abs($time2 - $time1) / 3600,2);
                            // echo $difference."<br>";

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
                            echo $working_hours."<br>";
                        }
                        else
                        {
                            $job_rate= 0;
                            echo $job_rate."<br>";
                        }

                        // if(!empty($vbl7))
                        // {
                        //     echo $vbl7->job_rate."<br>";

                        //     $time1 = strtotime($vbl7->start);
                        //     $time2 = strtotime($vbl7->finish);
                        //     $difference = round(abs($time2 - $time1) / 3600,2);

                        //     $var3 = $vbl7->break;
                        //     if($var3 == "00:30")
                        //     $difference = $difference - 0.50;
                        //     if($var3 == "00:45")
                        //     $difference = $difference - 0.75;
                        //     if($var3 == "01:00")
                        //     $difference = $difference - 1.00;
                        //     if($var3 == "01:15")
                        //     $difference = $difference - 1.25;
                        //     if($var3 == "01:30")
                        //     $difference = $difference - 1.50;
                        //     if($var3 == "01:45")
                        //     $difference = $difference - 1.75;
                        //     if($var3 == "02:00")
                        //     $difference = $difference - 2.00;

                        //     $working_hours = $difference;
                        //     $total_hours = $total_hours + $difference;

                        //     // echo $working_hours."<br>";
                        //     if($working_hours > 8)
                        //     {
                        //         $number = 8;
                        //         echo $number."<br>";
                        //         $w_hours = $w_hours + $number;
                        //         $working_hours = $working_hours-8;
                        //         echo $working_hours."<br>";
                        //         $o_hours = $o_hours + $working_hours;
                        //     }
                        //     else
                        //     {
                        //         echo $working_hours."<br>";
                        //         $o_hours = $o_hours + $working_hours;
                        //         $number = 0;
                        //         echo $number."<br>";
                        //         $w_hours = $w_hours + $number;
                        //     }
                        // }
                        // else
                        // {
                        //     $number = 0;
                        //     echo $number."<br>";
                        //     $number2 = 0;
                        //     echo $number2."<br>";
                        // }
                    }
                    // echo $total_hours."<br>";
                    // echo $w_hours."<br>";
                    // echo $o_hours."<br>";
                }
            }


        }
        else
            return redirect('login');
    }

    public function export_csv()
    {
        if(session()->get('s_uname'))
        {
            //pls try
            return Excel::download(new UserExport,'UserList.xlsx');
        }
        else
            return redirect('login');
    }
}
