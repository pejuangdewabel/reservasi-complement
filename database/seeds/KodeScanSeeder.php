<?php

use App\Model\KodeScanDufan;
use Illuminate\Database\Seeder;

class KodeScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $kode = mt_rand(1, 100);
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
                $kode = mt_rand(1, 100);
            }
        } catch (\Throwable $e) {
            # code...
        }
    }
}
