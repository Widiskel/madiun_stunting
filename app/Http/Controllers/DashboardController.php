<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Puskesmas2020;
use App\Helper;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = Helper::getPuskesmasData('puskesmas_2020',$request->search);

        return view('puskesmas.index',$data);
    }
    public function show($id)
    {
        $data = Helper::getPuskesmasDetail($id,'puskesmas_2020');
   
        
        return view('puskesmas.show',$data);
    }
}
