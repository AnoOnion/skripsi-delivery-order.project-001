<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KendaraanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicle = [
            [
                'id_admin'      => 1,
                'plat_nomer'    => 'G 3745 AGB',
                'nama_merk'     => 'Viar Tossa 400-12 Swallow',
                'volume_bensin' => 20,
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'plat_nomer'    => 'G 2563 GBA',
                'nama_merk'     => 'Viar Tossa Hercules Xb 150 Cc',
                'volume_bensin' => 20,
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('kendaraan')->insert($vehicle);
    }
}
