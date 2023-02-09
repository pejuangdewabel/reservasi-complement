<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use App\Model\KodeScanDufan;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function index()
    {
        try {
            $kode = mt_rand(1111111111, 9999999999);
            $check = KodeScanDufan::where('kode', $kode)->first();
            while ($kode != $check) {
                $data = array(
                    'no_referensi'  => 'SELEBGRAM',
                    'kode'          => $kode,
                    'mulai_berlaku' => '2023-01-15',
                    'akhir_berlaku' => '2023-01-15',
                    'status'        => '1',
                    'waktu_masuk'   => null,
                    'keterangan'    => '-',
                    'jenis_tiket'   => '245',
                    'kuota'         => 10
                );
                KodeScanDufan::create($data);
                $kode = mt_rand(1111111111, 9999999999);
            }
        } catch (\Throwable $e) {
            # code...
        }
    }
}
