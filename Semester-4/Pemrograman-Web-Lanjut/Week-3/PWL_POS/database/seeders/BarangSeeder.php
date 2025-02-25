<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kategori_id' => 1, 'barang_kode' => 'ELE001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 5500000],
            ['kategori_id' => 1, 'barang_kode' => 'ELE002', 'barang_nama' => 'Smartphone', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['kategori_id' => 2, 'barang_kode' => 'PAK001', 'barang_nama' => 'Baju', 'harga_beli' => 100000, 'harga_jual' => 150000],
            ['kategori_id' => 2, 'barang_kode' => 'PAK002', 'barang_nama' => 'Celana', 'harga_beli' => 120000, 'harga_jual' => 170000],
            ['kategori_id' => 3, 'barang_kode' => 'MAK001', 'barang_nama' => 'Roti', 'harga_beli' => 5000, 'harga_jual' => 10000],
        ];

        DB::table('m_barang')->insert($data);
    }
}

