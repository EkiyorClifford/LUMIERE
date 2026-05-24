# Code Documentation - May 9, 2026

## Overview
Added comprehensive senior developer comments throughout the LUMIÈRE codebase to explain design decisions, patterns, and implementation logic. All comments are written as if a senior dev is explaining to a junior dev.

---

## Controllers (app/Http/Controllers/)

### ProductController.php ✅
**Lines commented:** 1-225 (entire file)
**Key sections explained:**
- Import statements and their purpose
- `index()` method: Filtering logic, eager loading, N+1 prevention
- `show()` method: Route model binding, relationship loading, related products algorithm
- `collections()` method: Collection listing with product eager loading
- `showCollection()` method: Reusing shop view with pre-filters

**Teaching points:**
- Why we use Schema::hasTable() for safety checks
- How route model binding works with custom route keys
- Eager loading strategies to prevent N+1 queries
- Related products algorithm (same collection OR category)

### CartController.php ✅
**Lines commented:** 1-338 (entire file)
**Key sections explained:**
- Guest vs authenticated user handling
- Session vs database storage patterns
- API response formats for AJAX requests
- Cart count calculation and badge updates

**Teaching points:**
- Session storage key format (product_id-variant_id)
- Why we return cart_count in JSON responses
- Error handling for AJAX vs form requests
- Eager loading product.primaryImage for cart drawer

### WishlistController.php ✅
**Lines commented:** 1-192 (entire file)
**Key sections explained:**
- Toggle behavior (add if exists, remove if exists)
- Session vs database storage for guests
- JSON response format with action type

**Teaching points:**
- Why wishlist is simpler than cart (just product IDs)
- Session array management (array_diff, array_values)
- Action response for JavaScript UI updates

---

## Models (app/Models/)

### Product.php ✅
**Lines commented:** 1-130 (entire file)
**Key sections explained:**
- Soft deletes usage and reasoning
- Fillable fields with examples
- Casts for type safety
- All relationships with purposes

**Teaching points:**
- Why soft deletes are better for e-commerce
- Route model binding with slug field
- Relationship naming conventions
- Primary image vs all images relationship

### Cart.php ✅
**Lines commented:** 1-37 (entire file)
**Key sections explained:**
- Simple cart container model
- User relationship
- Items relationship

**Teaching points:**
- Why cart model is minimal (logic in controller)
- Session_id field purpose (though not used in current implementation)

### CartItems.php ✅
**Lines commented:** 1-50 (entire file)
**Key sections explained:**
- Fillable fields explanations
- Relationship naming notes (should be lowercase for conventions)

**Teaching points:**
- Composite key concept (product_id-variant_id)
- Laravel naming conventions for relationships

### Wishlist.php ✅
**Lines commented:** 1-40 (entire file)
**Key sections explained:**
- Simple wishlist container
- User and items relationships

**Teaching points:**
- One-to-many relationship pattern
- Why wishlist is simpler than cart

### WishlistItem.php ✅
**Lines commented:** 1-39 (entire file)
**Key sections explained:**
- Simple product-linking model
- Foreign key relationships

**Teaching points:**
- Pivot table pattern
- Minimal data storage approach

---

## Routes (routes/web.php) ✅
**Lines commented:** 1-181 (entire file)
**Key sections explained:**
- Route organization by functionality
- REST conventions (PATCH, DELETE)
- API prefix separation
- Authentication middleware usage
- Route model binding

**Teaching points:**
- Why we use /api prefix for AJAX endpoints
- RESTful method selection
- Route grouping strategies
- SEO-friendly slug-based routing

---

## Views (resources/views/)

### welcome.blade.php (Navigation Section) ✅
**Lines commented:** 301-402 (navigation)
**Key sections explained:**
- Responsive design patterns (hidden md:)
- Authentication conditional rendering (@auth)
- Data flow from controllers to view
- CSS class purposes and z-index hierarchy

**Teaching points:**
- Blade directive usage (@auth, ?? fallbacks)
- Group hover for dropdown menus
- Mobile menu implementation
- Count badge data sources

### cart-drawer.blade.php ✅
**Lines commented:** 1-126 (entire file)
**Key sections explained:**
- Slide-out drawer CSS (translate-x-full)
- JavaScript function patterns
- AJAX request structure
- Error handling strategies

**Teaching points:**
- CSS transform for slide animations
- Async/await vs .then() patterns
- DOM query best practices
- Event handling and state management

### product_detail.blade.php (AJAX Functions) ✅
**Lines commented:** 610-731 (AJAX section)
**Key sections explained:**
- addProductToCart(): Complete request/response flow
- toggleWishlist(): Toggle pattern implementation
- Loading states and user feedback
- Error handling and recovery

**Teaching points:**
- Fetch API usage with proper headers
- CSRF token inclusion
- JSON payload construction
- Promise chain error handling

### welcome.blade.php (AJAX Functions) ✅
**Lines commented:** 1146-1224 (AJAX section)
**Key sections explained:**
- quickAdd(): Simplified cart addition
- Newsletter subscription: FormData usage

**Teaching points:**
- FormData vs JSON for forms
- Multiple badge updates
- Fallback strategies

---

## JavaScript Patterns Explained

### AJAX Request Pattern
```javascript
fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify(data)
})
.then(res => {
    if (!res.ok) return res.text().then(t => { throw new Error(t); });
    return res.json();
})
.then(data => {
    // Success handling
})
.catch(err => {
    // Error handling
});
```

### Key Teaching Points:
1. **Always include CSRF token** for Laravel security
2. **Handle both HTTP and network errors** properly
3. **Provide user feedback** (loading states, toasts)
4. **Update UI from API response** (don't assume success)
5. **Use proper HTTP methods** (POST for create, PATCH for update, DELETE for remove)

---

## Blade Patterns Explained

### Data Passing from Controller
```php
// In controller
return view('product_detail', [
    'product' => $product,
    'cartCount' => $cartCount,
    'wishlistCount' => $wishlistCount,
]);

// In view
<span>{{ $cartCount ?? 0 }}</span>
```

### Conditional Rendering
```php
@auth
    <!-- Authenticated user content -->
@else
    <!-- Guest user content -->
@endif
```

### Route Generation
```php
<a href="{{ route('product.show', $product->slug) }}">
```

---

## CSS Architecture Notes

### Z-Index Hierarchy
- z-[100]: Cart drawer (highest)
- z-[90]: Cart overlay
- z-[60]: Mobile menu
- z-[55]: Menu overlay
- z-50: Main navigation

### Animation Classes
- translate-x-full: Off-screen hiding
- opacity-0/100: Fade transitions
- group-hover: Parent hover effects

---

## Summary of Added Comments

1. **Controllers**: 3 files, ~500 lines of comments
2. **Models**: 5 files, ~200 lines of comments  
3. **Routes**: 1 file, ~150 lines of comments
4. **Views**: 3 files, ~300 lines of comments
5. **Total**: ~1150 lines of educational comments

All comments follow the "senior dev to junior dev" tone, explaining not just what the code does, but why it's designed that way and what patterns to follow in future development.
