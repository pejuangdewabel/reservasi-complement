<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HistoryTransaction extends Model
{
    protected $connection = 'mysql';
    protected $table = 'history_transactions';
    protected $fillable = [
        'jenisid',
        'kode',
        'unit',
        'jumlah_tiket',
        'jumlah_org_per_tiket',
        'tgl_mulai',
        'tgl_berlaku',
        'kendaran',
        'jumlah_kendaraan_per_tiket',
        'user_create'
    ];
    protected $casts = [
        'kode'      => 'array',
        'unit'      => 'array',
        'jenisid'   => 'array',
    ];
    public function relasi_user()
    {
        return $this->belongsTo(User::class, 'user_create', 'id');
    }
}
