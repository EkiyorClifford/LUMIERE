<?php

namespace Tests\Unit\Services;

use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cartService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cartService = app(CartService::class);
    }

    public function test_adding_product_to_authenticated_cart_increments_count(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->cartService->add($product->id, null, 2);

        $this->assertSame(2, $this->cartService->cartCount());
        $this->assertSame(2, $this->cartService->getCartData()->first()->quantity);
    }

    public function test_can_remove_product_from_authenticated_cart(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->cartService->add($product->id, null, 2);
        $removed = $this->cartService->remove($product->id, null);

        $this->assertTrue($removed);
        $this->assertSame(0, $this->cartService->cartCount());
    }

    public function test_guest_cart_data_stores_in_session(): void
    {
        $product = Product::factory()->create(['is_active' => true]);

        $this->cartService->add($product->id, null, 3);

        $this->assertSame(3, $this->cartService->cartCount());
        $this->assertSame($product->id, $this->cartService->getCartData()->first()->product->id);
    }

    public function test_update_quantity_removes_item_when_quantity_is_zero(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['is_active' => true]);

        auth()->login($user);

        $this->cartService->add($product->id, null, 3);
        $this->cartService->updateQuantity($product->id, null, 0);

        $this->assertSame(0, $this->cartService->cartCount());
    }
}
