<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                'nama_depan'    => 'Muh Husni',
                'nama_belakang' => 'Mubarok',
                'email'         => 'service@husni.or.id',
                'password'      => bcrypt('123456789'),
                'level'         => 'admin',
                'jenis_kelamin' => 'l',
                'tanggal_lahir' => '2000-12-25 00:00:00',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'nama_depan'    => 'Rendi',
                'nama_belakang' => 'Andy',
                'email'         => 'private@husni.or.id',
                'password'      => bcrypt('123456789'),
                'level'         => 'kurir',
                'jenis_kelamin' => 'l',
                'tanggal_lahir' => '2000-12-25 00:00:00',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('admin')->insert($admin);
    }
}
