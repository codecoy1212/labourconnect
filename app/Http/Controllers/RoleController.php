<?php

namespace App\Http\Controllers;

use App\Models\Job_User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function add_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
        $validator = Validator::make($request->all(),[
            'role_name'=> 'required|max:30|min:3|unique:roles,r_name',
        ],[
            'role_name.required' => 'Role Name is required.',
            'role_name.max' => 'Role Name must be within 30 characters.',
            'role_name.min' => 'Role Name must be of 3 characters.',
            'role_name.unique' => 'Role Name already exists in Database.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = new Role;
            $vbl->r_name = $request->role_name;
            $vbl->save();
        }
        }
        else
            return redirect('login');
    }

    public function show_roles()
    {
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('roles')->orderBy('id','desc')->paginate(10);
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function show_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl = Role::find($request->id);
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function edit_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'role_name'=> 'required|max:30|min:3|unique:roles,r_name,'.$request->id,
            ],[
                'role_name.required' => 'Role Name is required.',
                'role_name.max' => 'Role Name must be within 30 characters.',
                'role_name.min' => 'Role Name must be of 3 characters.',
                'role_name.unique' => 'Role Name already exists in Database.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = Role::find($request->id);
                $vbl->r_name = $request->role_name;
                $vbl->update();
            }
        }
        else
            return redirect('login');

    }

    public function del_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            Job_User::where('role_id',$request->id)->delete();

            $vbl = Role::find($request->id);
            $vbl->delete();
        }
        else
            return redirect('login');

    }

    public function search_role(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;

            $vbl = DB::table('roles')
            ->where('r_name', 'like',"%".$request->search."%")
            ->orwhere('id', 'like', "%".$request->search."%")
            ->orderBy('created_at', 'desc')->paginate(10);
            return $vbl;
        }
        else
            return redirect('login');

    }
}
