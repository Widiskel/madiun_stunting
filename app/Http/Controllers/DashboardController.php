<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puskesmas2020;
use App\Helper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = Helper::getPuskesmasData('puskesmas_2018',$request->search);

        return view('puskesmas.index',$data);
    }

    public  function get_by_years(Request $request, $id){
        if ($id == 2018){
            $year = 'puskesmas_2018';
        }
        elseif($id == 2019){
            $year = 'puskesmas_2019';
        }
        elseif($id == 2020){
            $year = 'puskesmas_2020';
        }
        elseif($id == 2021){
            $year = 'puskesmas_2021';
        }
        elseif($id == 2022){
            $year = 'puskesmas_2022';
        }
       $data = Helper::getPuskesByYears($year, $request->search);
    //    dd($data['years']);

       return view('puskesmas.get_by_years',$data);
    }
    public function show($id)
    {
        $data = Helper::getPuskesmasDetail($id,'puskesmas_2018');
        // dd($data);
        
        return view('puskesmas.show',$data);
    }
    public function show_by_years($id_y, $id)
    {
        $data = Helper::getPuskesmasDetailByYears($id, $id_y);
        // dd($data);
        
        return view('puskesmas.show',$data);
    }
}
