<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $jobs = array();

            $vbl = DB::table('jobs')
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

            return view('main.jobs', compact('jobs'));
        }
        else
            return redirect('login');

    }

    public function new_job()
    {
        if(session()->get('s_uname'))
        {
            $vbl = Company::all();

            $vbl2 = DB::table('jobs')->orderBy('id', 'desc')
            ->first();

            $vbl2 = $vbl2->id+1;
            return view('main.main2.new_job',compact('vbl','vbl2'));
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
            return view('main.reports');
        }
        else
            return redirect('login');

    }
}
