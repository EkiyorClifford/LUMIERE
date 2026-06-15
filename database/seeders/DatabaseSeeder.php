<?php

// C:\Users\HP\Desktop\Lumiere\database\seeders\DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->call([
                AdminSeeder::class,
                PostCategorySeeder::class,
                PostSeeder::class,
                CategorySeeder::class,
                CollectionSeeder::class,
                ProductSeeder::class,
                CollectionContentSeeder::class,
            ]);

            $consultant = Consultant::updateOrCreate(
                ['name' => 'Helene Garnier'],
                [
                    'title' => 'Senior Gemologist',
                    'location' => 'Paris Atelier',
                    'bio' => 'Specializing in rare stones, private appointments, and bespoke architectural settings.',
                    'avatar_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1200&auto=format&fit=crop',
                    'is_active' => true,
                ],
            );

            User::updateOrCreate(
                ['email' => 'julianne@example.com'],
                [
                    'name' => 'Julianne V.',
                    'password' => bcrypt('password'),
                    'consultant_id' => $consultant->id,
                    'membership_tier' => 'gold_circle',
                ],
            );

        });
    }
}
