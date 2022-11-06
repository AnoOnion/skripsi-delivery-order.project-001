<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productStock = [
            [
                'id_admin'          => 1,
                'id_produk'         => 1,
                'stok_awal'         => 2,
                'stok_sementara'    => 2,
                'stok_akhir'        => 2,
                'harga_beli'        => 16700,
                'harga_jual'        => 20000,
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ],
            [
                'id_admin'          => 1,
                'id_produk'         => 2,
                'stok_awal'         => 2,
                'stok_sementara'    => 2,
                'stok_akhir'        => 2,
                'harga_beli'        => 16000,
                'harga_jual'        => 22000,
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ],
            [
                'id_admin'          => 1,
                'id_produk'         => 3,
                'stok_awal'         => 2,
                'stok_sementara'    => 2,
                'stok_akhir'        => 2,
                'harga_beli'        => 18000,
                'harga_jual'        => 19000,
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ],
            [
                'id_admin'          => 1,
                'id_produk'         => 4,
                'stok_awal'         => 4,
                'stok_sementara'    => 4,
                'stok_akhir'        => 4,
                'harga_beli'        => 0,
                'harga_jual'        => 4000,
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ],
            [
                'id_admin'          => 1,
                'id_produk'         => 5,
                'stok_awal'         => 2,
                'stok_sementara'    => 2,
                'stok_akhir'        => 2,
                'harga_beli'        => 0,
                'harga_jual'        => 10000,
                'created_at'        => new \DateTime,
                'updated_at'        => new \DateTime
            ]
        ];

        DB::table('stok_produk')->insert($productStock);
    }
}
