<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InformasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $information = [
            [
                'id_admin'      => 1,
                'slug'          => 'Perkenalan-Tentang-Toko-San-Qua-Depot-Isi-Ulang-Air-Mineral-' . time(),
                'judul'         => 'Perkenalan Tentang Toko San Qua Depot Isi Ulang Air Mineral',
                'deskripsi'     => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Repellendus blanditiis voluptate voluptatum, cupiditate quae quas veritatis magni eveniet exercitationem accusamus, perspiciatis harum quos dolorum vel? Corporis distinctio recusandae tempora libero?',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('informasi')->insert($information);
    }
}
