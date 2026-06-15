<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Models\User;
use App\Services\WishlistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistServiceTest extends TestCase
{
    use RefreshDatabase;

    private WishlistService $wishlistService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wishlistService = app(WishlistService::class);
    }

    public function test_adding_product_to_authenticated_wishlist_increases_count(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->wishlistService->add($product->id);

        $this->assertSame(1, $this->wishlistService->count());
        $this->assertTrue($this->wishlistService->isInWishlist($product->id));
    }

    public function test_removing_product_from_authenticated_wishlist(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->wishlistService->add($product->id);
        $removed = $this->wishlistService->remove($product->id);

        $this->assertTrue($removed);
        $this->assertFalse($this->wishlistService->isInWishlist($product->id));
    }

    public function test_guest_wishlist_can_toggle_items_in_session(): void
    {
        $product = Product::factory()->create(['is_active' => true]);

        $this->wishlistService->add($product->id);

        $this->assertSame(1, $this->wishlistService->count());
        $this->assertTrue($this->wishlistService->isInWishlist($product->id));
    }

    public function test_clear_wishlist_removes_all_items(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->wishlistService->add($product->id);
        $this->wishlistService->clear();

        $this->assertSame(0, $this->wishlistService->count());
    }
}
