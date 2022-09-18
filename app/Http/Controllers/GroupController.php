<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Group;
use App\Product;
use App\Stock;
use DB;

class GroupController extends Controller
{
    public function index()
    {
        
        $Group = DB::table('groups')
            ->join('companies', 'groups.company_id', '=', 'companies.id')
            ->select('groups.id','companies.company_name','groups.group_name','groups.created_at')
            ->get();

        if(request()->ajax())
        {
            return datatables()->of($Group)
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->group_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        $Company = Company::all(['id','company_name']);
        return view('group', compact('Company'));
    }

    public function addGroup(Request $request)
    {
        // dd((int)$request->company_id);
        $Group = new Group;
        $Group->company_id = (int) $request->company_id;
        $Group->group_name = strtoupper($request->group_name);
        $Group->save();

        if ($Group->id) {
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }

    public function deleteGroup($id)
    {
        $Group = Group::find($id)->delete();
        $Product = Product::where('group_id',$id)->delete();
        $Stock = Stock::where('group_id',$id)->delete();
        // $flight->delete();
        if ($Group) {
            return response()->json(['success' => 'Delete successfully !!!']);
        } else {
            return response()->json(['falied' => 'Delete falied !!!']);
        }
    }

    public function getGroup()
    {  

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){

             $branch = $this->settings->all_branch();
            return view('backend.ajax.get_branch',compact('branch'));
        }else{
             $branch=$this->settings->branchname_loginemployee();
            //  $branch = $this->settings->all_branch();
            return view('backend.ajax.get_login_user_branch',compact('branch'));
        }
       
    }

}
