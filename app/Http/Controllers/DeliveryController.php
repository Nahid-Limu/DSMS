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

class DeliveryController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public function index()
    {
        return view('delivery');
    }

    public function getProduct($c_id,$g_id)
    {
        // dd($g_id);
        $Product = DB::table('products')
            // ->join('companies', 'products.company_id', '=', 'companies.id')
            // ->join('groups', 'products.group_id', '=', 'groups.id')
            ->join('stocks', 'products.id', '=', 'stocks.product_id')

            ->select('products.id','products.product_name','products.piece','stocks.stock_size','stocks.stock_piece')
            ->orderBy('products.group_id','products.company_id')
            ->where('products.company_id',$c_id)
            ->where('products.group_id',$g_id)
            ->get();
            // dd($Product);

            if (count($Product)) {
                // dd('data');
                if(request()->ajax())
                {
                    return datatables()->of($Product)
                            
                            ->addColumn('action', function($data){
                                $button = '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->product_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';
                                
                                return $button;
                            })
                            ->rawColumns(['action'])
                            ->addIndexColumn()
                            ->make(true);
                            
                }
                return view('delivery');
            } else {
                // dd('no data');
                return view('delivery');
            }
            
        
        
    }
}
