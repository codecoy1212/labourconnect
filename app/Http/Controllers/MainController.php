<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('main.dashboard');
    }

    public function jobs()
    {
        return view('main.jobs');
    }

    public function new_job()
    {
        return view('main.main2.new_job');
    }

    public function users()
    {
        return view('main.user');
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
