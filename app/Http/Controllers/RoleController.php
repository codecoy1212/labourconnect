<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function add_role(Request $request)
    {
        // return $request;

        $vbl = new Role;
        $vbl->r_name = $request->role_name;
        $vbl->save();
    }

    public function show_roles()
    {
        $vbl = DB::table('roles')->orderBy('id','desc')->paginate(6);
        return $vbl;
    }

    public function show_role(Request $request)
    {
        $vbl = Role::find($request->id);
        return $vbl;
    }

    public function edit_role(Request $request)
    {
        // return $request;

        $vbl = Role::find($request->id);
        $vbl->r_name = $request->role_name;
        $vbl->update();
    }

    public function del_role(Request $request)
    {
        $vbl = Role::find($request->id);
        $vbl->delete();
    }

    public function search_role(Request $request)
    {
        // return $request;

        $vbl = DB::table('roles')
                ->where('r_name', 'like',"%".$request->search."%")
                ->orwhere('id', 'like', "%".$request->search."%")
                ->orderBy('created_at', 'desc')->paginate(6);
        return $vbl;
    }
}
