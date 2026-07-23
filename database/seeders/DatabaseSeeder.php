<?php

namespace Database\Seeders;

use App\Imports\DestinasiImport;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Database\Seeder;
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