<?php

// C:\Users\HP\Desktop\Lumiere\routes\web.php

// Import all the controllers we'll be using
// Grouping them by functionality: Product/Shop, Cart/Checkout, User/Profile, etc.
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BespokeController as AdminBespokeController;
use App\Http\Controllers\Admin\CollectionContentController as AdminCollectionContentController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\AtelierController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConciergeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SizerKitRequestController;
use App\Http\Controllers\WishlistController;
// Route facade for defining routes
use Illuminate\Support\Facades\Route;

// Home page - using CartController::home because we need cart/wishlist counts for the header
// This loads the welcome view with cart data for the navigation badges
Route::get('/', [CartController::class, 'home'])->name('home');

// === SHOP & PRODUCT ROUTES ===
// Collections listing page - shows all curated collections
Route::get('/collections', [ProductController::class, 'collections'])->name('collections');

// Individual collection view - reuses shop view but pre-filtered by collection
// Using slug for SEO-friendly URLs
Route::get('/collections/{slug}', [ProductController::class, 'showCollection'])->name('collections.show');

// Main shop page with all products and filters
// Handles category filtering via URL parameter and query string filters
Route::get('/shop', [ProductController::class, 'index'])->name('shop');

// Product detail page - using route model binding with slug
// Laravel automatically finds the product by slug field
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
// === STATIC PAGES ===
// Atelier/bespoke services page
Route::get('/atelier', [AtelierController::class, 'index'])->name('atelier');

// Simple static pages - using closure routes since no controller logic needed
// These are mostly informational pages that don't need dynamic data
Route::get('/size-guide', function () {
    return view('size-guide');
})->name('size-guide');

Route::get('/faq', function () {
    return view('FAQ');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/shipping', function () {
    return view('SHIPPING');
})->name('shipping');

// French bespoke pages - maintaining brand language consistency
Route::get('/sur-mesure', function () {
    return view('sur-mesure');
})->name('sur-mesure');

Route::get('/bespoke', function () {
    return view('bespoke');
})->name('bespoke');

// === BLOG/JOURNAL ROUTES ===
// Journal/blog listing page
Route::get('/journal', [PostController::class, 'index'])->name('journal');

// Posts filtered by category
Route::get('/journal/category/{slug}', [PostController::class, 'category'])->name('post.category');

// Individual blog post - using slug for SEO
Route::get('/journal/{slug}', [PostController::class, 'show'])->name('post.show');

// === FORM SUBMISSION ROUTES ===
// All POST routes for form submissions
// These handle contact requests, newsletter signup, etc.
Route::post('/atelier/request', [AtelierController::class, 'store'])->name('atelier.request');
Route::post('/concierge-request', [ConciergeController::class, 'store'])->name('concierge.request');
Route::post('/sizer-kit-request', [SizerKitRequestController::class, 'store'])->name('sizer-kit.request');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter');

// === CART ROUTES ===
// API routes for AJAX cart operations
// Using /api prefix to separate API endpoints from page routes
// These return JSON responses for JavaScript cart updates
Route::prefix('api')->group(function () {
    // Get cart items (for cart drawer AJAX updates)
    Route::get('/cart', [CartController::class, 'index'])->name('api.cart.index');

    // Add item to cart (from product detail page)
    Route::post('/cart/add', [CartController::class, 'add'])->name('api.cart.add');

    // Remove item from cart
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('api.cart.remove');

    // Update cart item (generic add/update method)
    Route::post('/cart/update', [CartController::class, 'update'])->name('api.cart.update');

    // Update specific item quantity (from cart page)
    // Using PATCH for partial updates following REST conventions
    Route::patch('/cart/{item}/quantity', [CartController::class, 'updateQuantity'])->name('api.cart.quantity');

    // Delete cart item (using DELETE method for REST compliance)
    Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('api.cart.destroy');

    // Get cart count for badge updates
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('api.cart.count');
});

// Full cart page - not under /api prefix because it returns HTML view
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// === CHECKOUT ROUTES ===
// All checkout routes require authentication
// Users must be logged in to place orders
Route::middleware('auth')->group(function () {
    // Checkout form page
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');

    // Process checkout - handles payment, order creation, etc.
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Order success page - shows order confirmation
    // Passes order reference for displaying specific order details
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// === USER PROFILE / L'ESPACE ROUTES ===
// All profile routes require authentication
// L'Espace is the private member dashboard
Route::middleware('auth')->group(function () {
    // Main profile/dashboard page - L'Espace
    // Using French name for brand consistency
    Route::get('/lespace', [ProfileController::class, 'show'])->name('profile.show');

    // Edit profile form
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profile - using PATCH for partial updates
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Delete account - using DELETE for REST compliance
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order history page
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');

    // Book appointment with consultant
    Route::post('/profile/book-appointment', [ProfileController::class, 'bookAppointment'])->name('profile.book-appointment');

    // Contact consultant
    Route::post('/profile/contact-consultant', [ProfileController::class, 'contactConsultant'])->name('profile.contact-consultant');
});

// === WISHLIST ROUTES ===
// Wishlist works for both guests and authenticated users
// Controller handles session vs database storage automatically

// Full wishlist page
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

// Toggle wishlist item (add if not present, remove if present)
// This is the main endpoint for the heart icon toggle
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');

// Force remove from wishlist (different from toggle)
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Get wishlist count for badge updates (API endpoint)
Route::get('/api/wishlist/count', [WishlistController::class, 'count'])->name('wishlist.count');

// === ADMIN AUTH ROUTES ===
Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login']);
    });

    Route::middleware('auth.admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->middleware('admin.can:view-dashboard')->name('admin.dashboard');

        Route::middleware('admin.can:manage-catalog')->group(function () {
            Route::get('collections', [AdminCollectionController::class, 'index'])->name('admin.collections.index');
            Route::resource('products', AdminProductController::class)->except(['show'])->names('admin.products');
            Route::patch('products/{product}/toggle-active', [AdminProductController::class, 'toggleActive'])->name('admin.products.toggle-active');
        });

        Route::middleware('admin.can:manage-content')->group(function () {
            Route::resource('collection-contents', AdminCollectionContentController::class)->except(['show'])->names('admin.collection-contents');
            Route::patch('collection-contents/{collectionContent}/toggle-active', [AdminCollectionContentController::class, 'toggleActive'])->name('admin.collection-contents.toggle-active');
            Route::resource('posts', AdminPostController::class)->except(['show'])->names('admin.posts');
        });

        Route::get('bespoke', [AdminBespokeController::class, 'index'])->middleware('admin.can:manage-bespoke')->name('admin.bespoke.index');
        Route::get('orders', [AdminOrderController::class, 'index'])->middleware('admin.can:manage-orders')->name('admin.orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->middleware('admin.can:manage-orders')->name('admin.orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->middleware('admin.can:manage-orders')->name('admin.orders.updateStatus');
        Route::get('users', [AdminUsersController::class, 'index'])->middleware('admin.can:manage-customers')->name('admin.users.index');
        Route::get('users/{user}', [AdminUsersController::class, 'show'])->middleware('admin.can:manage-customers')->name('admin.users.show');
        Route::patch('users/{user}/toggle-active', [AdminUsersController::class, 'toggleActive'])->middleware('admin.can:manage-customers')->name('admin.users.toggle-active');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});

// Load Laravel's default authentication routes
// This includes login, registration, password reset, etc.
// Keeping it separate since it's boilerplate Laravel auth
require __DIR__.'/auth.php';
