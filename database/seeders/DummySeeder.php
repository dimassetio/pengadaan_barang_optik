<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
  public function run()
  {
    DB::table('pasiens')->insert([
      ['nama' => 'Ahmad Yusuf', 'nohp' => '081234567890', 'alamat' => 'Jl. Mawar No. 123', 'created_at' => now(), 'updated_at' => now()],
      ['nama' => 'Siti Aisyah', 'nohp' => '081987654321', 'alamat' => 'Jl. Melati No. 456', 'created_at' => now(), 'updated_at' => now()],
      ['nama' => 'Budi Santoso', 'nohp' => '081223344556', 'alamat' => 'Jl. Kenanga No. 789', 'created_at' => now(), 'updated_at' => now()],
      ['nama' => 'Dewi Kartika', 'nohp' => '081998877665', 'alamat' => 'Jl. Dahlia No. 101', 'created_at' => now(), 'updated_at' => now()],
      ['nama' => 'Rina Permata', 'nohp' => '081556677889', 'alamat' => 'Jl. Tulip No. 202', 'created_at' => now(), 'updated_at' => now()],
    ]);

    DB::table('frames')->insert([
      ['kode' => 'FRM001', 'warna' => 'Hitam', 'quantity' => 10, 'tanggal_masuk' => '2024-01-01', 'penerima' => 'Ahmad Santoso', 'created_at' => now(), 'updated_at' => now()],
      ['kode' => 'FRM002', 'warna' => 'Putih', 'quantity' => 15, 'tanggal_masuk' => '2024-02-01', 'penerima' => 'Siti Permata', 'created_at' => now(), 'updated_at' => now()],
      ['kode' => 'FRM003', 'warna' => 'Merah', 'quantity' => 20, 'tanggal_masuk' => '2024-03-01', 'penerima' => 'Budi Yusuf', 'created_at' => now(), 'updated_at' => now()],
      ['kode' => 'FRM004', 'warna' => 'Biru', 'quantity' => 25, 'tanggal_masuk' => '2024-04-01', 'penerima' => 'Ahmad Santoso', 'created_at' => now(), 'updated_at' => now()],
      ['kode' => 'FRM005', 'warna' => 'Hijau', 'quantity' => 30, 'tanggal_masuk' => '2024-05-01', 'penerima' => 'Budi Yusuf', 'created_at' => now(), 'updated_at' => now()],
    ]);

    DB::table('lensas')->insert([
      ['merk' => 'Essilor', 'jenis' => 'Single Vision', 'ukuran' => '1.50', 'quantity' => 20, 'tanggal_masuk' => '2024-03-01', 'penerima' => 'Ahmad Santoso', 'created_at' => now(), 'updated_at' => now()],
      ['merk' => 'Zeiss', 'jenis' => 'Progressive', 'ukuran' => '1.60', 'quantity' => 25, 'tanggal_masuk' => '2024-04-01', 'penerima' => 'Siti Permata', 'created_at' => now(), 'updated_at' => now()],
      ['merk' => 'Hoya', 'jenis' => 'Bifocal', 'ukuran' => '1.67', 'quantity' => 15, 'tanggal_masuk' => '2024-05-01', 'penerima' => 'Budi Yusuf', 'created_at' => now(), 'updated_at' => now()],
      ['merk' => 'Rodenstock', 'jenis' => 'Single Vision', 'ukuran' => '1.74', 'quantity' => 18, 'tanggal_masuk' => '2024-06-01', 'penerima' => 'Ahmad Santoso', 'created_at' => now(), 'updated_at' => now()],
      ['merk' => 'Nikon', 'jenis' => 'Progressive', 'ukuran' => '1.80', 'quantity' => 22, 'tanggal_masuk' => '2024-07-01', 'penerima' => 'Siti Permata', 'created_at' => now(), 'updated_at' => now()],
    ]);
  }
}
