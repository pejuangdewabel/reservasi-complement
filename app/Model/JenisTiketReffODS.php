<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JenisTiketReffODS extends Model
{
    protected $connection = 'mysqlods';
    protected $table = 'jenis_tiket_reff';
}
