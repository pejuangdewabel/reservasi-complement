<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'mysql';
    protected $table = 'unit';
    protected $fillable = [
        'kode',
        'nama_unit',
        'remark',
    ];
    // protected $casts = [
    //     'list' => 'array'
    // ];
}
