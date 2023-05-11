<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Models\Puskesmas2020;
use App\LCG;

class Helper
{
    public static function getPuskesmasData($table, $search)
    {
        if ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where(function ($q) {
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
                array_push($interval,array(0,$val));
            }else{
                $val = floor($value*100);
                $new_begining = $interval[array_key_last($interval)][1];
                array_push($interval,array($new_begining+1,$val));
            }
        }
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
    public static function data(){

        $numbers = array(344, 382, 313, 313, 350, 310, 313, 344, 310, 312, 312, 312);

        return $numbers;
    }
    public static function getPuskesmasDetail($id, $table)
    {
        if ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where('No', $id)->first();
            $detail =  [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'year' => 2020,
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


            $data['puskesmas'] = $detail;
            $data['probabilitas'] = Helper::distribusi_probabilitas(array_slice($detail,2,12));
            $data['komulatif'] = Helper::distribusi_komulatif($data['probabilitas']);
            $data['interval'] = Helper::interval_acak($data['komulatif']);
            $data['random'] = Helper::randomNumber();
            $data['peramalan'] = Helper::peramalan($data['interval'],$data['random'],array_slice($data['puskesmas'], 2, 12));


            $data['total']=[
                'stunting' => $puskesmas->Januari + $puskesmas->Febuari + $puskesmas->Maret + $puskesmas->April + $puskesmas->Mei + $puskesmas->Juni + $puskesmas->July + $puskesmas->Agustus + $puskesmas->September + $puskesmas->Oktober + $puskesmas->November + $puskesmas->Desember,
                'probabilitas' => array_sum($data['probabilitas']),
                'peramalan' => array_sum($data['peramalan']),
            ];
        // } elseif ($table == 'puskesmas_2021') {
        //     $puskesmas = Puskesmas2021::where('No', $id)->first();
        //     $detail = [
        //         'puskesmas_name' => $puskesmas->PUSKESMAS,
        //         'b1' => $puskesmas->Januari,
        //         'b2' => $puskesmas->Febuari,
        //         'b3' => $puskesmas->Maret,
        //         'b4' => $puskesmas->April,
        //         'b5' => $puskesmas->Mei,
        //         'b6' => $puskesmas->Juni,
        //         'b7' => $puskesmas->July,
        //         'b8' => $puskesmas->Agustus,
        //         'b9' => $puskesmas->September,
        //         'b10' => $puskesmas->Oktober,
        //         'b11' => $puskesmas->November,
        //         'b12' => $puskesmas->Desember,
        //     ];

        //     $data['puskesmas'] = $detail;
        // } elseif ($table == 'puskesmas_2022') {
        //     $puskesmas = Puskesmas2022::where('No', $id)->first();
        //     $detail = [
        //         'puskesmas_name' => $puskesmas->PUSKESMAS,
        //         'b1' => $puskesmas->Januari,
        //         'b2' => $puskesmas->Febuari,
        //         'b3' => $puskesmas->Maret,
        //         'b4' => $puskesmas->April,
        //         'b5' => $puskesmas->Mei,
        //         'b6' => $puskesmas->Juni,
        //         'b7' => $puskesmas->July,
        //         'b8' => $puskesmas->Agustus,
        //         'b9' => $puskesmas->September,
        //         'b10' => $puskesmas->Oktober,
        //         'b11' => $puskesmas->November,
        //         'b12' => $puskesmas->Desember,
        //     ];

        //     $data['puskesmas'] = $detail;
        }
        return $data;
    }
}
