<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Models\Puskesmas2020;

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
        $dk=[
        ];
        $nx = $data[0];
        for ($i=0; $i < count($data); $i++) { 
            if ($i==0) {
                array_push($dk,$data[$i]);
                # code...
            }
            else {
                $dn = $data[$i]+$nx;
                array_push($dk,$dn);
                # code...
            }
            $nx=$data[$i];
            # code...
        }

        
        // dd($dk);
        
        return $dk;

    }
    public static function interval_acak()
    {
        
        $angka=[];
        
        for ($i=0; $i < 99; $i++) { 
            array_push($angka,$i);
        }
        // dd($angka);
        $ia=[
            0 => array_slice($angka,0,8),
            1 => array_slice($angka,8,11),
            2 => array_slice($angka,19,7),
            3 => array_slice($angka,24,9),
            4 => array_slice($angka,32,5),
            5 => array_slice($angka,37,6),
            6 => array_slice($angka,43,8),
            7 => array_slice($angka,51,9),
            8 => array_slice($angka,60,4),
            9 => array_slice($angka,64,9),
            10 => array_slice($angka,73,4),
            11 => array_slice($angka,77,9),

        ];
        
        return $ia;

    }
    public static function getPuskesmasDetail($id, $table)
    {
        if ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where('No', $id)->first();
            $detail = [ 0 => [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'year' => 2020,
                'Januari' => $puskesmas->Januari,
                'Febuari' => $puskesmas->Febuari,
                'Maret' => $puskesmas->Maret,
                'April' => $puskesmas->April,
                'Mei' => $puskesmas->Mei,
                'Juni' => $puskesmas->Juni,
                'July' => $puskesmas->July,
                'Agustus' => $puskesmas->Agustus,
                'September' => $puskesmas->September,
                'Oktober' => $puskesmas->Oktober,
                'November' => $puskesmas->November,
                'Desember' => $puskesmas->Desember,
                'total' => $puskesmas->Januari + $puskesmas->Febuari + $puskesmas->Maret + $puskesmas->April + $puskesmas->Mei + $puskesmas->Juni + $puskesmas->July + $puskesmas->Agustus + $puskesmas->September + $puskesmas->Oktober + $puskesmas->November + $puskesmas->Desember

            ],
            1 => [              
            ],
            2 => [              
            ],
            3 => [

            ],
            ];
            // dd(array_slice($detail,2,12));
            // $data['distribusi'] = [ 0=> Helper::distribusi_probabilitas(array_slice($detail,2,12))];
            $detail[1]= Helper::distribusi_probabilitas(array_slice($detail[0],2,12));
            $detail[2]= Helper::distribusi_komulatif($detail[1]);
            $detail[3]= Helper::interval_acak();
            // dd($detail);
            $data['puskesmas'] = $detail;
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
