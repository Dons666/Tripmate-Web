<?php

namespace Database\Seeders;

use App\Imports\DestinasiImport;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Travel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. User Admin
        |--------------------------------------------------------------------------
        */
        User::firstOrCreate(
            ['email' => 'admin@tripmate.id'],
            [
                'name' => 'Admin TripMate',
                'role' => 'admin',
                'password' => bcrypt('admin123'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Seed Kategori
        |--------------------------------------------------------------------------
        */
        $kategoris = [
            'Wisata Budaya',
            'Wisata Sejarah',
            'Wisata Edukasi',
            'Taman Hiburan',
            'Wisata Bahari',
            'Desa Wisata',
            'Wisata Alam',
            'Wisata Religi',
            'Wisata Buatan',
            'Wisata Kuliner',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate([
                'nama_kategori' => $kategori,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Seed Mitra Agen Travel & User Akun Travel
        |--------------------------------------------------------------------------
        */
        $travelUsers = [
            [
                'email'    => 'travel@nusa.com',
                'name'     => 'Nusa Horizon Tour & Travel',
                'password' => bcrypt('travel123'),
                'role'     => 'travel',
            ],
            [
                'email'    => 'travel@java.com',
                'name'     => 'Java Explorer Trans & Travel',
                'password' => bcrypt('travel123'),
                'role'     => 'travel',
            ],
            [
                'email'    => 'travel@parahyangan.com',
                'name'     => 'Parahyangan Heritage Tour',
                'password' => bcrypt('travel123'),
                'role'     => 'travel',
            ],
        ];

        foreach ($travelUsers as $tu) {
            User::firstOrCreate(['email' => $tu['email']], $tu);
        }

        $userNusa = User::where('email', 'travel@nusa.com')->first();
        $userJava = User::where('email', 'travel@java.com')->first();
        $userPara = User::where('email', 'travel@parahyangan.com')->first();

        $travels = [
            [
                'user_id'     => $userNusa->id ?? null,
                'nama_travel' => 'Nusa Horizon Tour & Travel',
                'slug'        => 'nusa-horizon-tour-travel',
                'layanan'     => 'Paket Tur Lengkap, Driver & Tiket Masuk',
                'deskripsi'   => 'Layanan agen travel profesional mencakup penjemputan armada AC, driver berpengalaman, tiket masuk destinasi wisata, serta panduan lokal.',
                'harga_paket' => 350000,
                'rating'      => 4.8,
                'kota'        => 'Bandung',
                'kontak'      => '0812-3456-7890',
                'gambar'      => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'user_id'     => $userJava->id ?? null,
                'nama_travel' => 'Java Explorer Trans & Travel',
                'slug'        => 'java-explorer-trans-travel',
                'layanan'     => 'Open Trip, Bus Pariwisata & Tour Guide',
                'deskripsi'   => 'Solusi travel rombongan dan privat keluarga dengan fasilitas armada luxury bus, tour leader ramah, serta paket makan & dokumentasi foto.',
                'harga_paket' => 500000,
                'rating'      => 4.9,
                'kota'        => 'Yogyakarta',
                'kontak'      => '0821-9876-5432',
                'gambar'      => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'user_id'     => $userPara->id ?? null,
                'nama_travel' => 'Parahyangan Heritage Tour',
                'slug'        => 'parahyangan-heritage-tour',
                'layanan'     => 'City Tour & Wisata Budaya/Kuliner',
                'deskripsi'   => 'Menyediakan perjalanan privat jelajah situs bersejarah, pusat oleh-oleh khas, serta rekomendasi tempat kuliner otentik.',
                'harga_paket' => 250000,
                'rating'      => 4.7,
                'kota'        => 'Bandung',
                'kontak'      => '0857-1122-3344',
                'gambar'      => 'https://images.unsplash.com/photo-1506012787146-f92b2d7d6d96?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        if (Schema::hasTable('travels')) {
            foreach ($travels as $t) {
                Travel::updateOrCreate(
                    ['slug' => $t['slug']],
                    $t
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 5. Import Dataset Destinasi (Hasil Preprocessing)
        |--------------------------------------------------------------------------
        */
        $csvPath = database_path('seeders/data_tripmate_preprocessing_final.csv');

        if (file_exists($csvPath)) {

            $this->command->info('===========================================');
            $this->command->info('Mengimport dataset TripMate...');
            $this->command->info('File : data_tripmate_preprocessing_final.csv');
            $this->command->info('===========================================');

            Excel::import(new DestinasiImport, $csvPath);

            $this->command->info('===========================================');
            $this->command->info('Import dataset berhasil!');
            $this->command->info('===========================================');

        } else {

            $this->command->error('===========================================');
            $this->command->error('File CSV tidak ditemukan!');
            $this->command->error('Lokasi: ' . $csvPath);
            $this->command->error('===========================================');

        }
    }
}