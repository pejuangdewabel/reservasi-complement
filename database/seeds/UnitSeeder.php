<?php

use App\Model\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'kode'      => 'SW',
                'nama_unit' => 'SEA WORLD',
                'remark'    => '-'
            ],
            [
                'kode'      => 'DF',
                'nama_unit' => 'DUNIA FANTASI',
                'remark'    => '-'
            ],
            [
                'kode'      => 'PG',
                'nama_unit' => 'PGU Ancol',
                'remark'    => '-'
            ],
            [
                'kode'      => 'OD',
                'nama_unit' => 'OCEAN DREAM SAMUDRA',
                'remark'    => '-'
            ],
            [
                'kode'      => 'AW',
                'nama_unit' => 'ATLANTIS WATER ADVENTURES',
                'remark'    => '-'
            ],
            [
                'kode'      => 'JB',
                'nama_unit' => 'JAKARTA BIRD LAND',
                'remark'    => '-'
            ],
        );
        foreach ($data as $d) {
            Unit::create($d);
        }
    }
}
