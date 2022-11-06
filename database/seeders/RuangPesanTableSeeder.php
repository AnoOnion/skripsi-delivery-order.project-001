<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangPesanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $message = [
            [
                'id_user'       => 1,
                'id_admin'      => 2,
                'pengirim'      => 'user',
                'pesan'         => 'hi',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_user'       => 1,
                'id_admin'      => 2,
                'pengirim'      => 'admin',
                'pesan'         => 'hi, juga',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('ruang_pesan')->insert($message);
    }
}
