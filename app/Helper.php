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
        } elseif ($table == 'puskesmas_2021') {
            $puskesmas = Puskesmas2020::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $data['jumlah_puskesmas'] = $puskesmas->count('no');
            $data['puskesmas'] = $puskesmas->paginate(15);
        } elseif ($table == 'puskesmas_2022') {
            $puskesmas = Puskesmas2020::where(function ($q) {
                $q->where('PUSKESMAS', 'LIKE', '%' . request()->search . '%');
            });
            $data['jumlah_puskesmas'] = $puskesmas->count('no');
            $data['puskesmas'] = $puskesmas->paginate(15);
        }

        return $data;
    }

    public static function getPuskesmasDetail($id, $table)
    {
        if ($table == 'puskesmas_2020') {
            $puskesmas = Puskesmas2020::where('No', $id)->first();
            $detail = [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'b1' => $puskesmas->Januari,
                'b2' => $puskesmas->Febuari,
                'b3' => $puskesmas->Maret,
                'b4' => $puskesmas->April,
                'b5' => $puskesmas->Mei,
                'b6' => $puskesmas->Juni,
                'b7' => $puskesmas->July,
                'b8' => $puskesmas->Agustus,
                'b9' => $puskesmas->September,
                'b10' => $puskesmas->Oktober,
                'b11' => $puskesmas->November,
                'b12' => $puskesmas->Desember,
                'total' => $puskesmas->Januari + $puskesmas->Febuari + $puskesmas->Maret + $puskesmas->April + $puskesmas->Mei + $puskesmas->Juni + $puskesmas->July + $puskesmas->Agustus + $puskesmas->September + $puskesmas->Oktober + $puskesmas->November + $puskesmas->Desember,
            ];

            $data['puskesmas'] = (object) $detail;
        } elseif ($table == 'puskesmas_2021') {
            $puskesmas = Puskesmas2021::where('No', $id)->first();
            $detail = [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'b1' => $puskesmas->Januari,
                'b2' => $puskesmas->Febuari,
                'b3' => $puskesmas->Maret,
                'b4' => $puskesmas->April,
                'b5' => $puskesmas->Mei,
                'b6' => $puskesmas->Juni,
                'b7' => $puskesmas->July,
                'b8' => $puskesmas->Agustus,
                'b9' => $puskesmas->September,
                'b10' => $puskesmas->Oktober,
                'b11' => $puskesmas->November,
                'b12' => $puskesmas->Desember,
            ];

            $data['puskesmas'] = $detail;
        } elseif ($table == 'puskesmas_2022') {
            $puskesmas = Puskesmas2022::where('No', $id)->first();
            $detail = [
                'puskesmas_name' => $puskesmas->PUSKESMAS,
                'b1' => $puskesmas->Januari,
                'b2' => $puskesmas->Febuari,
                'b3' => $puskesmas->Maret,
                'b4' => $puskesmas->April,
                'b5' => $puskesmas->Mei,
                'b6' => $puskesmas->Juni,
                'b7' => $puskesmas->July,
                'b8' => $puskesmas->Agustus,
                'b9' => $puskesmas->September,
                'b10' => $puskesmas->Oktober,
                'b11' => $puskesmas->November,
                'b12' => $puskesmas->Desember,
            ];

            $data['puskesmas'] = $detail;
        }
        return $data;
    }
}
