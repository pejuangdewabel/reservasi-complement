<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DetailJenisTiket extends Model
{
    protected $connection = 'mysql';
    protected $table = 'detail_jenis_tikets';
    protected $fillable = [
        'unit_id',
        'kode_jenis_tiket',
        'kode_jenis'
    ];
    public function relasi_unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function relasi_jenis_tiket()
    {
        return $this->belongsTo(JenisTiket::class, 'kode_jenis_tiket', 'kode');
    }
}
