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
        | 2. User Dummy
        |--------------------------------------------------------------------------
        */
        User::firstOrCreate(
            ['email' => 'user@tripmate.id'],
            [
                'name' => 'User TripMate',
                'role' => 'user',
                'password' => bcrypt('user123'),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. User Testing untuk Rating
        |--------------------------------------------------------------------------
        */
        $testUsers = [
            ['name' => 'Joni', 'email' => 'joni@tripmate.id'],
            ['name' => 'Amel', 'email' => 'amel@tripmate.id'],
            ['name' => 'Juan', 'email' => 'juan@tripmate.id'],
            ['name' => 'Agul', 'email' => 'agul@tripmate.id'],
            ['name' => 'Gamu', 'email' => 'gamu@tripmate.id'],
            ['name' => 'Melba', 'email' => 'melba@tripmate.id'],
            ['name' => 'Joe Mama', 'email' => 'joemama@tripmate.id'],
            ['name' => 'King', 'email' => 'king@tripmate.id'],
            ['name' => 'Ferdi', 'email' => 'ferdi@tripmate.id'],
            ['name' => 'Budi Santoso', 'email' => 'budi@tripmate.id'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti@tripmate.id'],
            ['name' => 'Ahmad Ridho', 'email' => 'ahmad@tripmate.id'],
            ['name' => 'Rini Cahyani', 'email' => 'rini@tripmate.id'],
            ['name' => 'Doni Wijaya', 'email' => 'doni@tripmate.id'],
            ['name' => 'Lisa Mona', 'email' => 'lisa@tripmate.id'],
        ];

        foreach ($testUsers as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => 'user',
                    'password' => bcrypt('user123'),
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Seed Kategori
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