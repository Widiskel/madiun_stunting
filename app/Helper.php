<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Models\Puskesmas2018;
use App\Models\Puskesmas2019;
use App\Models\Puskesmas2020;
use App\Models\Puskesmas2021;
use App\Models\Puskesmas2022;
use App\LCG;

class Helper
{
    public static function getPuskesmasData($table, $search)
    {
        if ($table == 'puskesmas_2018') {
            $puskesmas = Puskesmas2018::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $data['jumlah_puskesmas'] = $puskesmas->count('no');
            $data['puskesmas'] = $puskesmas->paginate(15);
        // } elseif ($table == 'puskesmas_2021') {
        //     $puskesmas = Puskesmas2020::where(function ($q) {
        //         $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
        //     });
        //     $data['jumlah_puskesmas'] = $puskesmas->count('no');
        //     $data['puskesmas'] = $puskesmas->paginate(15);
        // } elseif ($table == 'puskesmas_2022') {
        //     $puskesmas = Puskesmas2020::where(function ($q) {
        //         $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
        //     });
        //     $data['jumlah_puskesmas'] = $puskesmas->count('no');
        //     $data['puskesmas'] = $puskesmas->paginate(15);
        }

        return $data;
    }
    public static function getPuskesByYears($table, $search)
    {
        
        if ($table == 'puskesmas_2018') {
            $puskesmas = Puskesmas2018::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $id_y = 'puskesmas_2018';
        }
        elseif ($table == 'puskesmas_2019') {
            $puskesmas = Puskesmas2019::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $id_y = 'puskesmas_2019';
        }
        elseif ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $id_y = 'puskesmas_2020';
        }
        elseif ($table == 'puskesmas_2021') {
            $puskesmas = Puskesmas2021::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });

            $id_y = 'puskesmas_2021';
        }
        elseif ($table == 'puskesmas_2022') {
            $puskesmas = Puskesmas2022::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $id_y = 'puskesmas_2021';
        }
        
        $data['jumlah_puskesmas'] = $puskesmas->count('no');
        $data['puskesmas'] = $puskesmas->paginate(15);
        $data['years'] = $id_y;
        // dd( $data['jumlah_puskesmas'], $data['puskesmas']);


        return $data;
    }

    public static function distribusi_probabilitas($data)
    {
        // $total_data = $data['Januari'] + $data['Febuari'] + $data['Maret'] + $data['April'] + $data['Mei'] + $data['Juni'] + $data['July'] + $data['Agustus'] +$data['September'] +$data['Oktober'] + $data['November'] + $data['Desember'];
        $rv=array_sum($data);
        // $distrib = $data / $total_data;
        $list = [];
        foreach($data as $key){
            $distrib = $key / $rv;
            array_push($list, $distrib);

        }
        // dd($list);
        
        return $list;

    }
    public static function distribusi_komulatif($data)
    {
        $komulatif = [];

        foreach ($data as $key => $value) {
            if($key == 0){
                array_push($komulatif,$value);
            }else{
                $new_komulatif  = $komulatif[array_key_last($komulatif)]+$value;
                array_push($komulatif,$new_komulatif);
            }
        }
        return $komulatif;

    }
    public static function interval_acak($komulatif)
    {
        $interval = [];
        foreach ($komulatif as $key => $value) {
            if($key == 0){
                $val = floor($value*100);
                array_push($interval,array(0,$val-1));
            }else{
                $val = floor($value*100);
                $new_begining = $interval[array_key_last($interval)][1];
                // dd($new_begining);
                array_push($interval,array($new_begining+1,$val-1));
            }
        }
        // dd($interval);
        $result = array();
        foreach ($interval as $rule) {
            $result[] = range($rule[0], $rule[1]);
        }
        return $result;
    }
    public static function randomNumber(){

        $lcg = new LCG(81, 5, 7, 99);
        $numbers = array();
        for ($i = 0; $i <= 11; $i++) {
            $numbers[$i] = $lcg->getNext();
        }
        return $numbers;
    }
    public static function persentase($data_real, $data_ramalan){
        $result = [];
        for ($i=0; $i < count($data_ramalan); $i++) { 
            $numbers = $data_real[$i] / $data_ramalan[$i] * 100;
            array_push($result, $numbers);
        }
        
        return $result;
    }
    public static function peramalan($interval , $angka, $data){
        // dd($interval,$angka,$data);
        $peramalan = [];
        foreach ($angka as $key=>$num) { 
            foreach ($interval as $index=>$int) {
                if(in_array($num,$int)){
                    // dd($num,$int,$data[$key]);
                    array_push($peramalan,$data[$index]);
                }
            }
        }
        // dd($peramalan);
        return $peramalan;
    }
    public static function at_ft($absolut_error, $data_real){
        $list = [];
        for ($i=0 ; $i < count($absolut_error)  ; $i++ ) { 
            array_push($list, $absolut_error[$i] / $data_real[$i]);
        }
        return $list;
    }
    public static function nilai_error($data_asli, $peramalan){
        $list = [];
        for ($i=0; $i < count($data_asli) ; $i++) { 
            array_push($list, $data_asli[$i] - $peramalan[$i]);
        }
        // dd($list);
        return $list;
    }
    public static function absolute_error($data_asli, $peramalan){
        $list = [];
        for ($i=0; $i < count($data_asli) ; $i++) { 
            array_push($list, abs($data_asli[$i] - $peramalan[$i]));
        }
        return $list;
    }
    public static function data(){

        $numbers = array(344, 382, 313, 313, 350, 310, 313, 344, 310, 312, 312, 312);

        return $numbers;
    }
    public static function MAPE($data){
        return $data / 12 * 100;
    }
    public static function getPuskesmasDetail($id, $table)
    {
        if ($table == 'puskesmas_2018') {
            $puskesmas = Puskesmas2018::where('No', $id)->first();
            $puskesmas_next = Puskesmas2019::where('No', $id)->first();
            $year = '2018';
            $year_next = '2019';
            $detail =  [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'year' => 2018,
                0 => $puskesmas->Januari,
                1 => $puskesmas->Febuari,
                2 => $puskesmas->Maret,
                3 => $puskesmas->April,
                4 => $puskesmas->Mei,
                5 => $puskesmas->Juni,
                6 => $puskesmas->July,
                7 => $puskesmas->Agustus,
                8 => $puskesmas->September,
                9 => $puskesmas->Oktober,
                10 => $puskesmas->November,
                11 => $puskesmas->Desember,
            ];
            $detail_next_year =  [
                'puskesmas_name' => $puskesmas_next->PUSKESMAS,
                'year' => $year_next,
                0 => $puskesmas_next->Januari,
                1 => $puskesmas_next->Febuari,
                2 => $puskesmas_next->Maret,
                3 => $puskesmas_next->April,
                4 => $puskesmas_next->Mei,
                5 => $puskesmas_next->Juni,
                6 => $puskesmas_next->July,
                7 => $puskesmas_next->Agustus,
                8 => $puskesmas_next->September,
                9 => $puskesmas_next->Oktober,
                10 => $puskesmas_next->November,
                11 => $puskesmas_next->Desember,
            ];


            $data['puskesmas'] = $detail;
            $data['data_next_years'] = $detail_next_year;
            $data['year_next'] = $year_next;
            $data['probabilitas'] = Helper::distribusi_probabilitas(array_slice($detail,2,12));
            $data['komulatif'] = Helper::distribusi_komulatif($data['probabilitas']);
            $data['interval'] = Helper::interval_acak($data['komulatif']);
            $data['random'] = Helper::randomNumber();
            $data['peramalan'] = Helper::peramalan($data['interval'],$data['random'],array_slice($data['puskesmas'], 2, 12));
            $data['persentase'] = Helper::persentase(array_slice($data['puskesmas'], 2, 12), $data['peramalan']);
            $data['nilai_error'] = Helper::nilai_error(array_slice($data['data_next_years'], 2, 12), $data['peramalan']);
            $data['absolute_error'] = Helper::absolute_error(array_slice($data['data_next_years'], 2, 12), $data['peramalan']);
            $data['at_ft'] = Helper::at_ft($data['absolute_error'], array_slice($data['data_next_years'],2,12));
            $data['mape'] = Helper::MAPE(array_sum($data['at_ft']));
            // dd(abs(-34));
            // dd($data['nilai_error']);

            $data['total']=[
                'stunting' => $puskesmas->Januari + $puskesmas->Febuari + $puskesmas->Maret + $puskesmas->April + $puskesmas->Mei + $puskesmas->Juni + $puskesmas->July + $puskesmas->Agustus + $puskesmas->September + $puskesmas->Oktober + $puskesmas->November + $puskesmas->Desember,
                'probabilitas' => array_sum($data['probabilitas']),
                'peramalan' => array_sum($data['peramalan']),
                'data_next' => array_sum(array_slice($data['data_next_years'],2, 12)),
                'error' => array_sum($data['nilai_error']),
                'absolute_error' => array_sum($data['absolute_error']),
                'at_ft' => array_sum($data['at_ft'])
            ];

        }
        return $data;
    }
    public static function getPuskesmasDetailByYears($id, $table)
    {
        if ($table == 'puskesmas_2018') {
            $puskesmas = Puskesmas2018::where('No', $id)->first();
            $puskesmas_next = Puskesmas2019::where('No', $id)->first();
            $year = '2018';
            $year_next = '2019';
        }
        elseif ($table == 'puskesmas_2019') {
            $puskesmas = Puskesmas2019::where('No', $id)->first();
            $puskesmas_next = Puskesmas2020::where('No', $id)->first();
            $year = '2019';
            $year_next = '2020';
        }
        elseif ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where('No', $id)->first();
            $puskesmas_next = Puskesmas2021::where('No', $id)->first();
            $year = '2020';
            $year_next = '2021';
        }
        elseif ($table == 'puskesmas_2021') {
            $puskesmas = Puskesmas2021::where('No', $id)->first();
            $puskesmas_next = Puskesmas2022::where('No', $id)->first();
            $year = '2021';
            $year_next = '2022';
        }
        elseif ($table == 'puskesmas_2022') {
            $puskesmas = Puskesmas2022::where('No', $id)->first();
            $puskesmas_next = Puskesmas2022::where('No', $id)->first();
            $year = '2022';
            $year_next = '2023';
        }
        
        $detail =  [
            'puskesmas_name' => $puskesmas->PUSKESMAS,
            'year' => $year,
            0 => $puskesmas->Januari,
            1 => $puskesmas->Febuari,
            2 => $puskesmas->Maret,
            3 => $puskesmas->April,
            4 => $puskesmas->Mei,
            5 => $puskesmas->Juni,
            6 => $puskesmas->July,
            7 => $puskesmas->Agustus,
            8 => $puskesmas->September,
            9 => $puskesmas->Oktober,
            10 => $puskesmas->November,
            11 => $puskesmas->Desember,
        ];
        $detail_next_year =  [
            'puskesmas_name' => $puskesmas_next->PUSKESMAS,
            'year' => $year_next,
            0 => $puskesmas_next->Januari,
            1 => $puskesmas_next->Febuari,
            2 => $puskesmas_next->Maret,
            3 => $puskesmas_next->April,
            4 => $puskesmas_next->Mei,
            5 => $puskesmas_next->Juni,
            6 => $puskesmas_next->July,
            7 => $puskesmas_next->Agustus,
            8 => $puskesmas_next->September,
            9 => $puskesmas_next->Oktober,
            10 => $puskesmas_next->November,
            11 => $puskesmas_next->Desember,
        ];

        $data['year_next'] = $year_next;
        $data['puskesmas'] = $detail;
        $data['probabilitas'] = Helper::distribusi_probabilitas(array_slice($detail,2,12));
        $data['komulatif'] = Helper::distribusi_komulatif($data['probabilitas']);
        $data['interval'] = Helper::interval_acak($data['komulatif']);
        $data['random'] = Helper::randomNumber();
        $data['peramalan'] = Helper::peramalan($data['interval'],$data['random'],array_slice($data['puskesmas'], 2, 12));
        $data['data_next_years'] = $detail_next_year; 
        $data['persentase'] = Helper::persentase(array_slice($data['puskesmas'], 2, 12), $data['peramalan']);
        $data['nilai_error'] = Helper::nilai_error(array_slice($data['data_next_years'], 2, 12), $data['peramalan']);
        $data['absolute_error'] = Helper::absolute_error(array_slice($data['data_next_years'], 2, 12), $data['peramalan']);
        $data['at_ft'] = Helper::at_ft($data['absolute_error'], array_slice($data['data_next_years'],2,12));
        $data['mape'] = Helper::MAPE(array_sum($data['at_ft']));


        $data['total']=[
            'stunting' => $puskesmas->Januari + $puskesmas->Febuari + $puskesmas->Maret + $puskesmas->April + $puskesmas->Mei + $puskesmas->Juni + $puskesmas->July + $puskesmas->Agustus + $puskesmas->September + $puskesmas->Oktober + $puskesmas->November + $puskesmas->Desember,
            'probabilitas' => array_sum($data['probabilitas']),
            'peramalan' => array_sum($data['peramalan']),
            'data_next' => array_sum(array_slice($data['data_next_years'],2, 12)),
            'error' => array_sum($data['nilai_error']),
            'absolute_error' => array_sum($data['absolute_error']),
            'at_ft' => array_sum($data['at_ft'])
        ];
        
        
        return $data;
    }
}
