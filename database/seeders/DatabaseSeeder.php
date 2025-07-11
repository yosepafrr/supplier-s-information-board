<?php

namespace Database\Seeders;

use UserSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin QC',
            'email' => 'qc@aski.user.com',
            'password' => Hash::make('qcpassword123'),
            'role' => 'admin_qc', // atau 'admin', 'user', dll sesuai kebutuhan
        ]);

        User::create([
            'name' => 'Admin PPIC',
            'email' => 'ppic@aski.user.com',
            'password' => Hash::make('ppicpassword123'),
            'role' => 'admin_ppic',
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@aski.user.com',
            'password' => Hash::make('superadminpassword123'),
            'role' => 'super_admin',
        ]);

        User::create([
            'name' => 'Supplier',
            'email' => 'supplier@aski.user.com',
            'password' => Hash::make('supplierpassword123'),
            'role' => 'user',
        ]);
    }
}
