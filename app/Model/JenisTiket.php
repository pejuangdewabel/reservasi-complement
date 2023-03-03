<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JenisTiket extends Model
{
    protected $connection = 'mysql';
    protected $table = 'jenis_tikets';
    protected $fillable = [
        'kode',
        'keterangan',
    ];
}
