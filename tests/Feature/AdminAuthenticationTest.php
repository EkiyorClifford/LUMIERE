<?php

// C:\Users\HP\Desktop\Lumiere\tests\Feature\AdminAuthenticationTest.php

use App\Models\Admin;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin login screen can be rendered', function () {
    $response = $this->get(route('admin.login'));

    $response->assertOk();
    $response->assertViewIs('admin.admin-login');
});

test('admins can authenticate using the admin guard', function () {
    $admin = Admin::create([
        'name' => 'Lumière Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $response = $this->post(route('admin.login'), [
        'email' => $admin->email,
        'password' => 'molotov',
        'remember' => '1',
    ]);

    $this->assertAuthenticatedAs($admin, 'admin');
    $response->assertRedirect(route('admin.dashboard'));
    expect($admin->refresh()->last_login_at)->not->toBeNull();
});

test('admins cannot authenticate with invalid credentials', function () {
    Admin::create([
        'name' => 'Lumière Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $response = $this->from(route('admin.login'))->post(route('admin.login'), [
        'email' => 'admin@lumiere.com',
        'password' => 'wrong-password',
    ]);

    $this->assertGuest('admin');
    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHasErrors([
        'email' => 'These credentials do not match our records.',
    ]);
});

test('admin dashboard requires admin authentication', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('admin.login'));
});

test('admins can logout', function () {
    $admin = Admin::create([
        'name' => 'Lumière Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $response = $this->actingAs($admin, 'admin')->post(route('admin.logout'));

    $this->assertGuest('admin');
    $response->assertRedirect(route('admin.login'));
});

test('authenticated admin section pages render', function () {
    $admin = Admin::create([
        'name' => 'Lumière Admin',
        'email' => 'admin@lumiere.com',
        'password' => 'molotov',
        'role' => 'superadmin',
    ]);

    $product = Product::create([
        'name' => 'Celestial Sapphire Ring',
        'slug' => 'celestial-sapphire-ring',
        'category' => 'ring',
        'description' => 'A luminous atelier piece.',
        'price' => 3450,
        'is_active' => true,
        'sort_order' => 0,
    ]);

    $post = Post::create([
        'title' => 'Atelier Notes',
        'slug' => 'atelier-notes',
        'excerpt' => 'A short atelier note.',
        'content' => 'A complete atelier note.',
        'featured_image' => 'posts/atelier.jpg',
        'is_published' => false,
    ]);

    $user = User::create([
        'name' => 'Julianne V.',
        'email' => 'julianne@example.com',
        'password' => 'password',
        'membership_tier' => 'gold_circle',
    ]);

    $order = Order::create([
        'user_id' => $user->id,
        'order_number' => 'LM-1001',
        'total' => 3450,
        'order_status' => 'pending',
    ]);

    $this->actingAs($admin, 'admin');

    foreach ([
        route('admin.dashboard'),
        route('admin.products.index'),
        route('admin.products.create'),
        route('admin.products.edit', $product),
        route('admin.orders.index'),
        route('admin.orders.show', $order),
        route('admin.posts.index'),
        route('admin.posts.create'),
        route('admin.posts.edit', $post),
        route('admin.users.index'),
        route('admin.users.show', $user),
    ] as $route) {
        $this->get($route)->assertOk();
    }
});
