<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HotelPGU extends Model
{
    protected $connection = 'mysqlhpgu';
    protected $table = 'guest';
    protected $fillable = [
        'guestID',
        'hotelID',
        'guestCode',
        'guestPemohon',
        'guestName',
        'guestInstansi',
        'guestJumlah',
        'guestTujuan',
        'guestKeperluan',
        'guestKendaraanByr',
        'guestKendaraan',
        'guestKendaraanType',
        'guestNopol',
        'guestCarColor',
        'guestCarMerk',
        'checkIn',
        'checkOut',
        'expireDate',
        'ticketYear',
        'entryID',
        'entryIDHistory',
        'ticketStatus',
        'jenis',
        'guestCard',
        'CreatedBy',
        'CreatedDate',
        'ModifiedBy',
        'ModifiedDate',
        'IsActive',
        'passType',
        'guestHeadCode'
    ];
    public $timestamps = false;
}
