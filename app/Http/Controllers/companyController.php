<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Company;
use DB;

class CompanyController extends Controller
{
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
        $Company->company_name = $request->company_name;
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
        // $flight->delete();
        if ($Company) {
            return response()->json(['success' => 'Delete successfully !!!']);
        } else {
            return response()->json(['falied' => 'Delete falied !!!']);
        }
    }
}
