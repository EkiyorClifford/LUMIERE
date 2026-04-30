<?php

namespace Database\Seeders;

use App\Models\BespokeProject;
use App\Models\Collection;
use App\Models\Consultant;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Treasure;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Consultants
        $helene = Consultant::create([
            'name' => 'Hélène G.',
            'title' => 'Senior Gemologist',
            'location' => 'Paris Atelier',
            'bio' => 'Specializing in rare stones and bespoke architectural settings.',
            'avatar_path' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=1976&auto=format&fit=crop',
        ]);

        // 2. Create Collections
        $eclat = Collection::create(['name' => "L'Éclat", 'slug' => 'leclat', 'description' => 'The Brilliance Collection.']);
        $lor = Collection::create(['name' => "L'Or", 'slug' => 'lor', 'description' => 'The Gold Collection.']);
        $perle = Collection::create(['name' => 'La Perle', 'slug' => 'la-perle', 'description' => 'The Pearl Collection.']);

        // 3. Create a VIP User
        $user = User::create([
            'name' => 'Julianne V.',
            'email' => 'julianne@example.com',
            'password' => bcrypt('password'),
            'consultant_id' => $helene->id,
            'membership_tier' => 'gold_circle',
        ]);

        // 4. Create a Featured Product
        $ring = Product::create([
            'name' => 'Aurelia Diamond Ring',
            'slug' => 'aurelia-diamond-ring',
            'collection_id' => $eclat->id,
            'category' => 'ring',
            'price' => 1850.00,
            'description' => 'A breathtaking testament to Lumière craftsmanship.',
            'is_active' => true,
        ]);

        // 5. Add Image to Product
        ProductImage::create([
            'product_id' => $ring->id,
            'image_path' => 'https://images.unsplash.com/photo-1635767798638-3e25273a8236?q=80&w=1964&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        // 6. Create a Bespoke Project for the User
        BespokeProject::create([
            'user_id' => $user->id,
            'consultant_id' => $helene->id,
            'project_title' => 'La Nuit Noir Commission',
            'current_step' => 'setting',
        ]);

        // 7. Add a "Treasure" to the User's Vault
        Treasure::create([
            'user_id' => $user->id,
            'product_id' => $ring->id,
            'serial_number' => 'LM-AU-2024-001',
            'purchased_at' => now()->subMonths(2),
        ]);
    }
}
