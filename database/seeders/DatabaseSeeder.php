<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Consultant;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->call([
                PostCategorySeeder::class,
                PostSeeder::class,
            ]);
            
            $this->seedCategories();

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

            $collector = User::updateOrCreate(
                ['email' => 'julianne@example.com'],
                [
                    'name' => 'Julianne V.',
                    'password' => bcrypt('password'),
                    'consultant_id' => $consultant->id,
                    'membership_tier' => 'gold_circle',
                ],
            );

            $collections = $this->seedCollections();

            $this->seedProduct($collections['leclat'], $collector, [
                'name' => 'Celestial Sapphire Ring',
                'slug' => 'celestial-sapphire-ring',
                'category' => 'ring',
                'price' => 3450,
                'sort_order' => 10,
                'description' => 'A 1.2-carat Sri Lankan sapphire encircled by pave-set diamonds and finished by hand in 18k white gold.',
                'images' => [
                    'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Stone', 'Sri Lankan sapphire', '1.2 ct'],
                    ['Diamonds', 'Pave-set natural diamonds', '0.45 ct'],
                    ['Metal', '18k white gold', null],
                    ['Craft time', '38', 'hours'],
                ],
                'variants' => [
                    ['Ring size 50', 'size', '50', 0, 3, 'LM-RNG-CEL-50'],
                    ['Ring size 52', 'size', '52', 0, 2, 'LM-RNG-CEL-52'],
                    ['Ring size 54', 'size', '54', 0, 0, 'LM-RNG-CEL-54'],
                    ['White Gold', 'material', '18k-white-gold', 0, 5, 'LM-RNG-CEL-WG'],
                    ['Yellow Gold', 'material', '18k-yellow-gold', 150, 3, 'LM-RNG-CEL-YG'],
                ],
            ]);

            $this->seedProduct($collections['lor'], $collector, [
                'name' => 'Aurelia Gold Necklace',
                'slug' => 'aurelia-gold-necklace',
                'category' => 'necklace',
                'price' => 2800,
                'sort_order' => 20,
                'description' => 'A sculptural 18k gold necklace with a hand-polished bespoke finish and soft collarbone drape.',
                'images' => [
                    'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Metal', '18k yellow gold', null],
                    ['Length', '45', 'cm'],
                    ['Finish', 'Mirror polish', null],
                    ['Craft time', '42', 'hours'],
                ],
                'variants' => [
                    ['42 cm', 'size', '42-cm', 0, 4, 'LM-NCK-AUR-42'],
                    ['45 cm', 'size', '45-cm', 0, 6, 'LM-NCK-AUR-45'],
                    ['18k Yellow Gold', 'material', '18k-yellow-gold', 0, 8, 'LM-NCK-AUR-YG'],
                    ['18k Rose Gold', 'material', '18k-rose-gold', 120, 2, 'LM-NCK-AUR-RG'],
                ],
            ]);

            $this->seedProduct($collections['la-perle'], $collector, [
                'name' => 'Odette Pearl Drop Earrings',
                'slug' => 'odette-pearl-drop-earrings',
                'category' => 'earrings',
                'price' => 1680,
                'sort_order' => 30,
                'description' => 'South Sea pearl drops suspended from diamond-set 18k gold hooks for a quiet, luminous profile.',
                'images' => [
                    'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Pearls', 'South Sea pearls', '9 mm'],
                    ['Diamonds', 'Natural diamonds', '0.18 ct'],
                    ['Metal', '18k yellow gold', null],
                    ['Craft time', '24', 'hours'],
                ],
                'variants' => [
                    ['Pair', 'size', 'pair', 0, 5, 'LM-EAR-ODE-PAIR'],
                    ['Single', 'size', 'single', -760, 2, 'LM-EAR-ODE-SINGLE'],
                    ['18k Yellow Gold', 'material', '18k-yellow-gold', 0, 4, 'LM-EAR-ODE-YG'],
                ],
            ]);

            $this->seedProduct($collections['lor'], $collector, [
                'name' => 'Maison Knot Signet',
                'slug' => 'maison-knot-signet',
                'category' => 'ring',
                'price' => 1850,
                'sort_order' => 40,
                'description' => 'A bold gold signet with a softened knot motif, made for daily wear and private engraving.',
                'images' => [
                    'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Metal', '18k yellow gold', null],
                    ['Engraving', 'Included up to 20 characters', null],
                    ['Finish', 'High polish', null],
                    ['Craft time', '31', 'hours'],
                ],
                'variants' => [
                    ['Ring size 52', 'size', '52', 0, 3, 'LM-RNG-KNT-52'],
                    ['Ring size 56', 'size', '56', 0, 4, 'LM-RNG-KNT-56'],
                    ['Ring size 58', 'size', '58', 0, 2, 'LM-RNG-KNT-58'],
                ],
            ]);
        });
    }

    private function seedCategories(): void
    {
        foreach ([
            ['Rings', 'ring', 'Engagement, signet, and cocktail rings.', 'fa-ring', 10],
            ['Necklaces', 'necklace', 'Pendants, chains, and high-jewelry necklaces.', 'fa-gem', 20],
            ['Bracelets', 'bracelet', 'Tennis bracelets and sculptural cuffs.', 'fa-circle', 30],
            ['Earrings', 'earrings', 'Studs, drops, and statement earrings.', 'fa-sparkles', 40],
            ['Bangles', 'bangle', 'Stacking bangles and carved gold forms.', 'fa-circle-notch', 50],
        ] as [$name, $slug, $description, $icon, $sortOrder]) {
            Category::updateOrCreate(
                ['slug' => $slug],
                compact('name', 'description', 'icon') + ['is_active' => true, 'sort_order' => $sortOrder],
            );
        }
    }

    /**
     * @return array<string, Collection>
     */
    private function seedCollections(): array
    {
        $data = [
            'leclat' => [
                'name' => "L'Eclat",
                'description' => 'Diamonds, sapphires, and luminous evening stones.',
                'cover_image' => 'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=1600&auto=format&fit=crop',
                'sort_order' => 10,
            ],
            'lor' => [
                'name' => "L'Or",
                'description' => 'Warm 18k and 22k gold forms with bespoke hand finishing.',
                'cover_image' => 'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=1600&auto=format&fit=crop',
                'sort_order' => 20,
            ],
            'la-perle' => [
                'name' => 'La Perle',
                'description' => 'Pearls selected for softness, symmetry, and quiet glow.',
                'cover_image' => 'https://images.unsplash.com/photo-1619856699906-09e1f58c98a1?q=80&w=1600&auto=format&fit=crop',
                'sort_order' => 30,
            ],
        ];

        $collections = [];

        foreach ($data as $slug => $attributes) {
            $collections[$slug] = Collection::updateOrCreate(
                ['slug' => $slug],
                $attributes + ['is_active' => true],
            );
        }

        return $collections;
    }

    /**
     * @param  array{
     *     name: string,
     *     slug: string,
     *     category: string,
     *     price: int,
     *     sort_order: int,
     *     description: string,
     *     images: list<string>,
     *     attributes: list<array{string, string, string|null}>,
     *     variants: list<array{string, string, string, int, int, string}>
     * }  $data
     */
    private function seedProduct(Collection $collection, User $reviewer, array $data): void
    {
        $product = Product::updateOrCreate(
            ['slug' => $data['slug']],
            [
                'name' => $data['name'],
                'collection_id' => $collection->id,
                'category' => $data['category'],
                'description' => $data['description'],
                'price' => $data['price'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ],
        );

        foreach ($data['images'] as $index => $imagePath) {
            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'image_path' => $imagePath],
                ['is_primary' => $index === 0, 'sort_order' => $index + 1],
            );
        }

        ProductAttribute::where('product_id', $product->id)->delete();
        foreach ($data['attributes'] as $index => [$key, $value, $unit]) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'key' => $key,
                'value' => $value,
                'unit' => $unit,
                'sort_order' => $index + 1,
            ]);
        }

        ProductVariant::where('product_id', $product->id)->delete();
        foreach ($data['variants'] as [$label, $type, $value, $priceModifier, $stock, $sku]) {
            ProductVariant::create([
                'product_id' => $product->id,
                'label' => $label,
                'type' => $type,
                'value' => $value,
                'price_modifier' => $priceModifier,
                'stock' => $stock,
                'sku' => $sku,
            ]);
        }

        Review::updateOrCreate(
            ['user_id' => $reviewer->id, 'product_id' => $product->id],
            [
                'rating' => 5,
                'comment' => 'The finish is exceptional, and the atelier follow-up made it feel deeply personal.',
                'is_approved' => true,
            ],
        );
    }
}
