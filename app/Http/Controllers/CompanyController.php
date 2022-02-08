<?php

namespace App\Http\Controllers;


use App\Models\Company;
use App\Models\DoneJob;
use App\Models\Job;
use App\Models\Job_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function add_company(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'c_name'=> 'required|min:3|unique:companies,c_name',
                'c_contact'=> 'required|min:3',
                'c_phone'=> 'required|numeric',
            ],[
                'c_name.required' => 'Company Name is required.',
                'c_name.min' => 'Company Name must be of 3 characters.',
                'c_name.unique' => 'Company Name already exists in Database.',
                'c_contact.required' => 'Contact Name is required.',
                'c_contact.min' => 'Contact Name must be of 3 characters.',
                'c_phone.required' => 'Phone is required.',
                // 'c_phone.digits' => 'Phone must be of 11 characters.',
                'c_phone.numeric' => 'Phone must be of integer type.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = new Company;
                $vbl->c_name = $request->c_name;
                $vbl->c_contact = $request->c_contact;
                $vbl->c_phone = $request->c_phone;
                $vbl->save();
            }
        }
        else
            return redirect('login');
    }

    public function show_companies()
    {
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('companies')->orderBy('id','desc')->paginate(10);
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function show_company(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl = Company::find($request->id);
            return $vbl;
        }
        else
            return redirect('login');

    }

    public function edit_company(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $validator = Validator::make($request->all(),[
                'c_name'=> 'required|min:3|unique:companies,c_name,'.$request->id,
                'c_contact'=> 'required|min:3',
                'c_phone'=> 'required|numeric',
            ],[
                'c_name.required' => 'Company Name is required.',
                'c_name.min' => 'Company Name must be of 3 characters.',
                'c_name.unique' => 'Company Name already exists in Database.',
                'c_contact.required' => 'Contact Name is required.',
                'c_contact.min' => 'Contact Name must be of 3 characters.',
                'c_phone.required' => 'Phone is required.',
                // 'c_phone.digits' => 'Phone must be of 11 characters.',
                'c_phone.numeric' => 'Phone must be of integer type.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                $vbl = Company::find($request->id);
                $vbl->c_name = $request->c_name;
                $vbl->c_contact = $request->c_contact;
                $vbl->c_phone = $request->c_phone;
                $vbl->update();
            }
        }
        else
            return redirect('login');

    }

    public function del_company(Request $request)
    {
        if(session()->get('s_uname'))
        {
            $vbl2 = Job::where('company_id',$request->id)->get();
            foreach ($vbl2 as $value) {
                Job_User::where('job_id',$value->id)->delete();
                DoneJob::where('job_id',$value->id)->delete();
            }
            Job::where('company_id',$request->id)->delete();

            $vbl = Company::find($request->id);
            $vbl->delete();
        }
        else
            return redirect('login');

    }

    public function search_company(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request;
            $vbl = DB::table('companies')
            ->where('c_name', 'like',"%".$request->search."%")
            ->orWhere('c_contact', 'like',"%".$request->search."%")
            ->orWhere('c_phone', 'like',"%".$request->search."%")
            ->orWhere('id', 'like', "%".$request->search."%")
            ->orderBy('created_at', 'desc')->paginate(10);
            return $vbl;
        }
        else
            return redirect('login');

    }
}
