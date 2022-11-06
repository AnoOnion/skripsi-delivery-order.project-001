<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'nama_depan'        => 'Muh Husni',
                'nama_belakang'     => 'Mubarok',
                'email'             => 'anoonion25@gmail.com',
                'email_verified_at' => '2022-03-24 11:01:08',
                'avatar'            => 'https://lh3.googleusercontent.com/a-/AOh14Gg9xDoJGoV-bL5A9ANu0mRmxGZI-DKEvAdX6-xKVQ=s96-c',
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ]
        ];

        DB::table('user')->insert($users);
    }
}
