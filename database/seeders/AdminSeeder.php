<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate([
            'role_id' => 1,
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'number' => '01234567899',
            'image' => 'seeder-images/S-Admin.png',
            'password' => Hash::make('12345678'),
            'is_active' => true,
            'is_deletable' => false
        ]);
    }
}
