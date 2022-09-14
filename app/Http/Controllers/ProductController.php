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

class ProductController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public function index()
    {

        $Product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->join('groups', 'products.group_id', '=', 'groups.id')
            ->select('products.id','companies.company_name','groups.group_name','products.product_name','products.size','products.piece','products.buy_price','products.sell_price')
            ->orderBy('products.group_id','products.company_id')
            ->get();
        // dd($Product );
        if(request()->ajax())
        {
            return datatables()->of($Product)
                    
                    ->addColumn('action', function($data){
                        $button = '<div class="d-flex justify-content-center"><button type="button" onclick="editProduct('.$data->id.')" name="edit" id="'.$data->id.'" class="edit btn btn-sm d-flex justify-content-center" data-toggle="modal" data-target="#EditProductModal" data-placement="top" title="Edit"><i class="fa fa-edit" style="color: aqua"> Edit</i></button>';
                        $button .= '<button type="button" onclick="deleteModal('.$data->id.',\''.$data->product_name.'\')" name="delete" id="'.$data->id.'" class="delete btn btn-sm" data-toggle="modal" data-target="#DeleteConfirmationModal" data-placement="top" title="Delete"  style="color: red"><i class="fa fa-trash"> Delete</i></button></div>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        $Company = Company::all(['id','company_name']);
        $Group = Group::all(['id','group_name']);
        
        return view('product', compact('Company','Group'));
    }

    public function addProduct(Request $request)
    {
        // dd($request->all());
        $Product = new Product;
        $Product->company_id = (int) $request->company_id;
        $Product->group_id = (int) $request->group_id;
        $Product->product_name = ucwords($request->product_name);
        $Product->size = ucwords($request->size);
        $Product->piece = (int) $request->piece;
        $Product->buy_price = (int) $request->buy_price;
        $Product->sell_price = (float) $request->sell_price;
        $Product->status = 1;
        $Product->save();

        if ($Product->id) {
            $Stock = new Stock;
            $Stock->product_id = $Product->id;
            $Stock->stock_size = 0;
            $Stock->stock_piece = 0;
            $Stock->save();
            return response()->json(['success' => 'Added successfully.']);
        } else {
            return response()->json(['failed' => 'Added failed.']);
        }
    }

    public function editProduct($id)
    {
        // $Product = Product::find($id);
        $Product = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->join('groups', 'products.group_id', '=', 'groups.id')
            ->select('products.id as id','companies.company_name','groups.group_name','products.product_name','products.size','products.piece','products.buy_price','products.sell_price')
            ->orderBy('products.group_id','products.company_id')
            ->where('products.id',$id)
            ->first();
        // dd($Product->id);
        return response()->json($Product);
    }

    public function updateProduct(Request $request)
    {
        // dd($request->all());
        $Product = Product::find($request->id);
        $Product->piece = $request->piece;
        $Product->buy_price = $request->buy_price;
        $Product->sell_price = $request->sell_price;
        $Product->save();
    
        if ($Product->id) {
            return response()->json(['success' => 'Update successfully !!!']);
        } else {
            return response()->json(['falied' => 'Update Nothing.']);
        }
    }

    public function deleteProduct($id)
    {
        $Product = Product::find($id)->delete();
        $Stock = Stock::where('product_id',$id)->delete();
        // $flight->delete();
        if ($Product) {
            return response()->json(['success' => 'Delete successfully !!!']);
        } else {
            return response()->json(['falied' => 'Delete falied !!!']);
        }
    }

    public function company_wise_group($c_id)
    {  

        $group = $this->settings->company_wise_group($c_id);
        // dd($group);
        return view('ajax.get_group',compact('group'));
       
    }

    
}
