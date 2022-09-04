<?php namespace App\Repositories;
use Carbon\Carbon;
use auth;
use Illuminate\Support\Facades\DB;

class Settings
{

    public function all_company(){
        return DB::table('companies')->get(['id','company_name']);
    }

    public function all_group(){
        return DB::table('groups')->get(['id','group_name']);
    }

    public function company_wise_group($c_id){
        return DB::table('groups')->where('company_id','=',$c_id)->get(['id','group_name']);
    }
}