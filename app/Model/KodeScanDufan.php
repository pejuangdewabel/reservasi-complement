<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KodeScanDufan extends Model
{
    protected $connection = 'mysqldufan';
    protected $table = 'kode_scan';
    protected $fillable = [
        'no_referensi',
        'kode',
        'mulai_berlaku',
        'akhir_berlaku',
        'status',
        'waktu_masuk',
        'keterangan',
        'jenis_tiket',
        'kuota'
    ];
    public $timestamps = false;
}
