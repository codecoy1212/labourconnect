<?php

namespace App\Http\Controllers;


use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function add_company(Request $request)
    {
        // return $request;

        $vbl = new Company;
        $vbl->c_name = $request->c_name;
        $vbl->c_contact = $request->c_contact;
        $vbl->c_phone = $request->c_phone;
        $vbl->save();
    }

    public function show_companies()
    {
        $vbl = DB::table('companies')->orderBy('id','desc')->paginate(6);
        return $vbl;
    }

    public function show_company(Request $request)
    {
        $vbl = Company::find($request->id);
        return $vbl;
    }

    public function edit_company(Request $request)
    {
        // return $request;

        $vbl = Company::find($request->id);
        $vbl->c_name = $request->c_name;
        $vbl->c_contact = $request->c_contact;
        $vbl->c_phone = $request->c_phone;
        $vbl->update();
    }

    public function del_company(Request $request)
    {
        $vbl = Company::find($request->id);
        $vbl->delete();
    }

    public function search_company(Request $request)
    {
        // return $request;

        $vbl = DB::table('companies')
                ->where('c_name', 'like',"%".$request->search."%")
                ->orWhere('c_contact', 'like',"%".$request->search."%")
                ->orWhere('c_phone', 'like',"%".$request->search."%")
                ->orWhere('id', 'like', "%".$request->search."%")
                ->orderBy('created_at', 'desc')->paginate(6);
        return $vbl;
    }
}
