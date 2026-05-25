<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->products() as $data) {
            $collection = Collection::where('slug', $data['collection'])->firstOrFail();

            $product = Product::withTrashed()->updateOrCreate(
                ['slug' => $data['slug']],
                Arr::except($data, ['collection', 'images', 'attributes', 'variants']) + [
                    'collection_id' => $collection->id,
                    'is_active' => true,
                ],
            );

            if ($product->trashed()) {
                $product->restore();
            }

            $this->syncImages($product, $data['images']);
            $this->syncAttributes($product, $data['attributes']);
            $this->syncVariants($product, $data['variants']);
        }
    }

    /**
     * @return list<array{
     *     name: string,
     *     slug: string,
     *     collection: string,
     *     category: string,
     *     price: int,
     *     sort_order: int,
     *     description: string,
     *     images: list<string>,
     *     attributes: list<array{string, string, string|null}>,
     *     variants: list<array{string, string, string, int, int, string}>
     * }>
     */
    private function products(): array
    {
        return [
            [
                'name' => 'Diamond Solitaire Ring',
                'slug' => 'diamond-solitaire-ring',
                'collection' => 'leclat',
                'category' => 'ring',
                'price' => 4200,
                'sort_order' => 10,
                'description' => 'A hand-finished 18k white gold solitaire set with a round brilliant diamond.',
                'images' => [
                    'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1611652022419-a9419f74343d?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Stone', 'Round brilliant diamond', '1.0 ct'],
                    ['Metal', '18k white gold', null],
                    ['Setting', 'Four-prong solitaire', null],
                ],
                'variants' => [
                    ['Ring size 50', 'size', '50', 0, 3, 'LM-RNG-SOL-50'],
                    ['Ring size 52', 'size', '52', 0, 4, 'LM-RNG-SOL-52'],
                    ['Platinum', 'material', 'platinum', 650, 2, 'LM-RNG-SOL-PT'],
                ],
            ],
            [
                'name' => 'Aurelia Gold Necklace',
                'slug' => 'aurelia-gold-necklace',
                'collection' => 'lor',
                'category' => 'necklace',
                'price' => 2800,
                'sort_order' => 20,
                'description' => 'A sculptural 18k gold necklace with a soft collarbone drape.',
                'images' => [
                    'https://images.unsplash.com/photo-1602751584552-8ba73aad9250?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Metal', '18k yellow gold', null],
                    ['Length', '45', 'cm'],
                    ['Finish', 'Mirror polish', null],
                ],
                'variants' => [
                    ['42 cm', 'size', '42-cm', 0, 4, 'LM-NCK-AUR-42'],
                    ['45 cm', 'size', '45-cm', 0, 6, 'LM-NCK-AUR-45'],
                    ['18k Rose Gold', 'material', '18k-rose-gold', 120, 2, 'LM-NCK-AUR-RG'],
                ],
            ],
            [
                'name' => 'Odette Pearl Drop Earrings',
                'slug' => 'odette-pearl-drop-earrings',
                'collection' => 'la-perle',
                'category' => 'earrings',
                'price' => 1680,
                'sort_order' => 30,
                'description' => 'South Sea pearl drops suspended from diamond-set 18k gold hooks.',
                'images' => [
                    'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?q=80&w=1600&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?q=80&w=1600&auto=format&fit=crop',
                ],
                'attributes' => [
                    ['Pearls', 'South Sea pearls', '9 mm'],
                    ['Diamonds', 'Natural diamonds', '0.18 ct'],
                    ['Metal', '18k yellow gold', null],
                ],
                'variants' => [
                    ['Pair', 'size', 'pair', 0, 5, 'LM-EAR-ODE-PAIR'],
                    ['Single', 'size', 'single', -760, 2, 'LM-EAR-ODE-SINGLE'],
                ],
            ],
        ];
    }

    /**
     * @param  list<string>  $images
     */
    private function syncImages(Product $product, array $images): void
    {
        foreach ($images as $index => $imagePath) {
            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'image_path' => $imagePath],
                ['is_primary' => $index === 0, 'sort_order' => $index + 1],
            );
        }
    }

    /**
     * @param  list<array{string, string, string|null}>  $attributes
     */
    private function syncAttributes(Product $product, array $attributes): void
    {
        ProductAttribute::where('product_id', $product->id)->delete();

        foreach ($attributes as $index => [$key, $value, $unit]) {
            ProductAttribute::create([
                'product_id' => $product->id,
                'key' => $key,
                'value' => $value,
                'unit' => $unit,
                'sort_order' => $index + 1,
            ]);
        }
    }

    /**
     * @param  list<array{string, string, string, int, int, string}>  $variants
     */
    private function syncVariants(Product $product, array $variants): void
    {
        ProductVariant::where('product_id', $product->id)->delete();

        foreach ($variants as [$label, $type, $value, $priceModifier, $stock, $sku]) {
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
    }
}
