<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'username' => 'admin1',
            'password' => Hash::make('admin123'),
        ]);

        Admin::create([
            'username' => 'admin2',
            'password' => Hash::make('admin456'),
        ]);
    }
}
