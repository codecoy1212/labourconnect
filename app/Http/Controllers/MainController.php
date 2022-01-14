<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Job;
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
            return view('main.reports');
        }
        else
            return redirect('login');

    }
}
