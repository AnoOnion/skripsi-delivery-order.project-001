<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanKendaraanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vehicleReport = [
            [
                'id_admin'      => 1,
                'id_kendaraan'  => 1,
                'kode_laporan'  => 'Ken.25135',
                'status'        => 'ada',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'id_kendaraan'  => 2,
                'kode_laporan'  => 'Ken.25140',
                'status'        => 'ada',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('laporan_kendaraan')->insert($vehicleReport);
    }
}
