<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pelanggan;
use App\Models\Suplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin')
        ]);
        Pelanggan::create([
            'nama_pelanggan' => 'PT.Yudiksana',
            'no_telp' => '08232309239',
            'alamat' => 'Labuhan Batu Tenggara',
        ]);
        Pelanggan::create([
            'nama_pelanggan' => 'Dafa Abdillah',
            'no_telp' => '08232309239',
            'alamat' => 'Labuhan Batu Barat',
        ]);
        Suplier::create([
            'nama_suplier' => 'Sandarma',
            'no_telp' => '08232309239',
            'alamat' => 'Sibolga Langit',
        ]);
        Suplier::create([
            'nama_suplier' => 'Algi Wali',
            'no_telp' => '08232309239',
            'alamat' => 'Nagan Raya',
        ]);
    }
}
