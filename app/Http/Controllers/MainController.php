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
        return view('main.dashboard');
    }

    public function jobs()
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

    public function new_job()
    {
        $vbl = Company::all();

        $vbl2 = DB::table('jobs')->orderBy('id', 'desc')
        ->first();

        $vbl2 = $vbl2->id+1;
        return view('main.main2.new_job',compact('vbl','vbl2'));
    }

    public function users()
    {
        $vbl = Role::all();

        return view('main.user',compact('vbl'));
    }

    public function companies()
    {
        return view('main.companies');
    }

    public function roles()
    {
        return view('main.roles');
    }

    public function reports()
    {
        return view('main.reports');
    }
}
