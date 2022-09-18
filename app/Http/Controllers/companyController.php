<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Group;
use App\Product;
use App\Stock;
use DB;
use App\Repositories\Settings;

class CompanyController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
    public function index()
    {
        
        $Company = Company::all();

        if(request()->ajax())
        {
            return datatables()->of($Company)
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->company_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        return view('company');
    }

    public function addCompany(Request $request)
    {
        $Company = new Company;
        $Company->company_name = strtoupper($request->company_name);
        $Company->save();

        if ($Company->id) {
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }

    public function deleteCompany($id)
    {
        $Company = Company::find($id)->delete();
        $Group = Group::where('company_id',$id)->delete();
        $Product = Product::where('company_id',$id)->delete();
        $Stock = Stock::where('company_id',$id)->delete();
        // $flight->delete();
        if ($Company) {
            return response()->json(['success' => 'Delete successfully !!!']);
        } else {
            return response()->json(['falied' => 'Delete falied !!!']);
        }
    }

    public function all_company()
    {  

        $company = $this->settings->all_company();
        // dd($group);
        return view('ajax.get_company',compact('company'));
       
    }
}
