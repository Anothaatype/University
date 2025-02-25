<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            $data = [
                ['penjualan_id' => 1, 'user_id' => 1, 'pembeli' => 'Pembeli 1', 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => now()],
                ['penjualan_id' => 2, 'user_id' => 2, 'pembeli' => 'Pembeli 2', 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => now()],
                ['penjualan_id' => 3, 'user_id' => 3, 'pembeli' => 'Pembeli 3', 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => now()],
                ['penjualan_id' => 4, 'user_id' => 1, 'pembeli' => 'Pembeli 4', 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => now()],
                ['penjualan_id' => 5, 'user_id' => 2, 'pembeli' => 'Pembeli 5', 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => now()],
            ];

            DB::table('t_penjualan')->insert($data);
        }
    
}
