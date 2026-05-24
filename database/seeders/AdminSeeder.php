<?php

// C:\Users\HP\Desktop\Lumiere\database\seeders\AdminSeeder.php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@lumiere.com'],
            [
                'name' => 'Lumière Admin',
                'password' => 'molotov',
                'role' => 'superadmin',
            ],
        );
    }
}
