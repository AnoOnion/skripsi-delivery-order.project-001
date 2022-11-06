<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = [
            [
                'id_admin'      => 1,
                'kode_item'     => 'PD-24680',
                'nama_item'     => 'Air Mineral Aqua Galon Asli 19L',
                'deskripsi'     => 'Harga sudah termasuk GALON ISI dan Tisu Pembersih, MINIMAL 1 galon + GALON ..Isi 19 liter, atau bisa di gabung dengan produk minuman kemasan',
                'berat'         => 8,
                'volume'        => 19,
                'kupon'         => 'tidak',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'kode_item'     => 'PD-24685',
                'nama_item'     => 'Air Mineral Le Minerale Galon Asli 15L',
                'deskripsi'     => 'Harga sudah termasuk GALON ISI dan Tisu Pembersih, MINIMAL 1 galon + GALON ..Isi 15 liter, atau bisa di gabung dengan produk minuman kemasan',
                'berat'         => 7,
                'volume'        => 15,
                'kupon'         => 'tidak',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'kode_item'     => 'PD-24690',
                'nama_item'     => 'Air Mineral Axogy Galon Asli 15L',
                'deskripsi'     => 'Harga sudah termasuk GALON ISI dan Tisu Pembersih, MINIMAL 1 galon + GALON ..Isi 19 liter, atau bisa di gabung dengan produk minuman kemasan',
                'berat'         => 8,
                'volume'        => 19,
                'kupon'         => 'tidak',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'kode_item'     => 'PD-24695',
                'nama_item'     => 'Air Mineral Galon Reffil 19L',
                'deskripsi'     => 'Harga sudah termasuk GALON ISI dan Tisu Pembersih, MINIMAL 1 galon + GALON ..Isi 19 liter, atau bisa di gabung dengan produk minuman kemasan',
                'berat'         => 8,
                'volume'        => 19,
                'kupon'         => 'ya',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ],
            [
                'id_admin'      => 1,
                'kode_item'     => 'PD-24700',
                'nama_item'     => 'Air Mineral RO (Reverse Osmosis) Galon Reffil 19L',
                'deskripsi'     => 'Harga sudah termasuk GALON ISI dan Tisu Pembersih, MINIMAL 1 galon + GALON ..Isi 19 liter, atau bisa di gabung dengan produk minuman kemasan',
                'berat'         => 8,
                'volume'        => 19,
                'kupon'         => 'tidak',
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            ]
        ];

        DB::table('produk')->insert($product);
    }
}
