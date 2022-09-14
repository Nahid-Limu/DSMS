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

class StockController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public function index()
    {

        $Stock = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->join('groups', 'products.group_id', '=', 'groups.id')
            ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->select('products.id','companies.company_name','groups.group_name','products.product_name',
            'products.size','products.piece','products.buy_price','products.sell_price','stocks.stock_size',
             DB::raw("((products.piece  * stocks.stock_size )) as `stock_piece`"),
            //  DB::raw("((products.buy_price  / products.piece ) * (products.piece  * stocks.stock_size ) )  as `invest`"),
            //  DB::raw("((products.sell_price  / products.piece ) * (products.piece  * stocks.stock_size ) )  as `sell`"),
             )
            ->orderBy('products.group_id','products.company_id')
            ->get();
        // dd($Stock);
        
        if(request()->ajax())
        {
            return datatables()->of($Stock)

                    ->addColumn('buy_price', function($data){
                                
                        $buy_price = $data->buy_price .' TK';
                        return $buy_price;
                    })

                    ->addColumn('sell_price', function($data){
                        
                        $sell_price = $data->sell_price .' TK';
                        return $sell_price;
                    })

                    ->addColumn('sizePiece', function($data){
                        
                        $sizePiece = $data->size.'='.$data->piece.'P';
                        return $sizePiece;
                    })

                    // ->addColumn('stock_size', function($data){
                        
                    //     $stock_size = $data->stock_piece / $data->piece;
                    //     return $stock_size;
                    // })

                    ->addColumn('invest', function($data){
                        
                        $invest = ($data->buy_price / $data->piece) *  $data->stock_piece .' TK';
                        return $invest;
                    })

                    ->addColumn('sell', function($data){
                        
                        $sell = ($data->sell_price / $data->piece) *  $data->stock_piece .' TK';
                        return $sell;
                    })

                    ->addColumn('action', function($data){
                        $button = '<button type="button" onclick="getStockProductViewData('.$data->id.')" name="delete" id="'.$data->id.'" class="delete btn btn-sm btn-success" data-toggle="modal" data-target="#StockProductModal" data-placement="top" title="Delete"  style="color: "><i class="fa fa-database"> Stock</i></button></div>';
                        
                        return $button;
                    })
                    ->rawColumns(['sizePiece','stock_size','invest','sell','action'])
                    ->addIndexColumn()
                    ->make(true);
                    
        }
        $Company = Company::all(['id','company_name']);
        $Group = Group::all(['id','group_name']);
        
        return view('stock', compact('Company','Group'));
        return view('stock');
    }

    public function viewStock($id)
    {
        // dd($id);
        // $Product = Product::find($id);
        $Product = DB::table('products')
            ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->join('groups', 'products.group_id', '=', 'groups.id')
            ->select('stocks.id as id','products.product_name','products.size','products.piece','products.buy_price','products.sell_price','stocks.stock_size','stocks.stock_piece')
            ->orderBy('products.group_id','products.company_id')
            ->where('products.id',$id)
            ->first();

        // $Product = Product::find($id);
        // dd($Product);
        return response()->json($Product);
    }

    public function addStock(Request $request)
    {
        // dd($request->all());
        $Stock = Stock::find($request->id);
        $Stock->stock_size = $request->total_stock_size;
        $Stock->stock_piece = $request->total_stock_piece;
        $Stock->save();
    
        if ($Stock->id) {
            return response()->json(['success' => 'Stock successfully.']);
        } else {
            return response()->json(['failed' => 'Stock failed.']);
        }
    }
}
