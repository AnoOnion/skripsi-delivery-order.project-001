<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            AdminTableSeeder::class,
            ProdukTableSeeder::class,
            StokProdukTableSeeder::class,
            KendaraanTableSeeder::class,
            LaporanKendaraanTableSeeder::class,
            RuangPesanTableSeeder::class,
            InformasiTableSeeder::class
        ]);
    }
}
