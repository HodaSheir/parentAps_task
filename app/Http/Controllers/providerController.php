<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class providerController extends Controller
{   
    public function searchFunction(){ 
            $datax_path = storage_path() . "/json/DataProviderX.json";
            $datay_path = storage_path() . "/json/DataProviderY.json";
            $datax = json_decode(file_get_contents($datax_path), true);
            $datay = json_decode(file_get_contents($datay_path), true);
        if( !request('provider') && !request('statusCode')&& 
            !request('currency') && !request('balanceMin') && !request('balanceMax')){
            //all providers
            $data[] = $datax['users'];
            $data[] = $datay['users'];
        }else if(request('provider')&& !request('statusCode')&& 
            !request('currency') && !request('balanceMin') && !request('balanceMax')){
            //search by provider 
            $search_file = request('provider');
            $data_path = storage_path() . "/json/{$search_file}.json";
            $data = file_get_contents($data_path);
            return $data;
        }elseif(request('statusCode')&& !request('provider')&& !request('currency') &&
                !request('balanceMin') && !request('balanceMax')) {
            //search by status code
            if(request('statusCode') =='authorised'){// 1 , 100
                $data[] = collect($datax['users'])->where("statusCode","LIKE","1")->all();
                $data[] = collect($datay['users'])->where("status","LIKE","100")->all();
            }else if(request('statusCode') =='decline'){ // 2 , 200
                $data[] = collect($datax['users'])->where("statusCode","LIKE","2")->all();
                $data[] = collect($datay['users'])->where("status","LIKE","200")->all();
            }else if(request('statusCode') =='refunded'){//3 , 300
                $data[] = collect($datax['users'])->where("statusCode","LIKE","3")->all();
                $data[] = collect($datay['users'])->where("status","LIKE","300")->all();
            }
        }elseif(request('currency')&& !request('provider')&& !request('statusCode')
                && !request('balanceMin') && !request('balanceMax')){
            //search by currency
            $data[] = collect($datax['users'])->where("Currency","=",request('currency'))->all();
            $data[] = collect($datay['users'])->where("currency","LIKE",request('currency'))->all();
            
        }elseif(request('balanceMin') && request('balanceMax') &&
                !request('statusCode')&& !request('provider')&& !request('currency')){//search by balance range
            $data[] = collect($datax['users'])->whereBetween('parentAmount', [request('balanceMin'), request('balanceMax')])->all();
            $data[] = collect($datay['users'])->whereBetween("balance",[request('balanceMin'), request('balanceMax')])->all();
        }
        return json_encode($data);
    }
}
