# Changelog — May 6, 2026

All changes made to the LUMIÈRE codebase on this date.

---

## 1. product_detail.blade.php — Column Name & Route Fixes

The view was referencing columns that don't exist in the database schema. Every mismatch has been corrected to match the actual migration column names.

### Route Name Fix

| Location | Before | After |
|----------|--------|-------|
| Nav wishlist link | `route('wishlist')` | `route('wishlist.index')` |

The registered route name is `wishlist.index`, not `wishlist`. This caused a runtime `RouteNotFoundException`.

### Variant Column Fixes

The `product_variants` table uses `type`, `value`, and `stock` — not `variant_type`, `variant_value`, or `stock_quantity`.

| Location | Before | After |
|----------|--------|-------|
| @php block groupBy | `->groupBy('variant_type')` | `->groupBy('type')` |
| @php block sum | `->sum('stock_quantity')` | `->sum('stock')` |
| Variant button class | `$variant->stock_quantity === 0` | `$variant->stock === 0` |
| Variant button onclick | `$variant->variant_value` | `$variant->value` |
| Variant button label | `{{ $variant->variant_value }}` | `{{ $variant->value }}` |
| Variant stock check | `$variants->where('stock_quantity', 0)` | `$variants->where('stock', 0)` |
| Variant button data-type | `data-type="{{ $type }}"` | `data-type="{{ Str::slug($type) }}"` |
| Variant label ID | `id="{{ $type }}-label"` | `id="{{ Str::slug($type) }}-label"` |
| Variant onclick type arg | `'{{ $type }}'` | `'{{ Str::slug($type) }}'` |

The `Str::slug()` wrapping ensures the type string (e.g. "Ring Size") becomes a valid HTML ID / JS selector (e.g. "ring-size"). Without it, spaces in type names would break `querySelector` and `getElementById`.

### Attribute Column Fixes

The `product_attributes` table uses `key` and `value` — not `attribute_key` or `attribute_value`.

| Location | Before | After |
|----------|--------|-------|
| Attribute key display | `$attr->attribute_key` | `$attr->key` |
| Attribute value display | `$attr->attribute_value` | `$attr->value` |

### is_featured Replacement

The `products` table has no `is_featured` column. Replaced with `sort_order` heuristic.

| Location | Before | After |
|----------|--------|-------|
| @php block | `$product->is_featured` | `$product->sort_order <= 5` |

Products with `sort_order` of 5 or less are treated as "new" for the badge logic.

---

## 2. CartController.php — API Response & Eager Loading

### cart_count in add() Response

The JS in `product_detail.blade.php` checks `data.cart_count` after adding to cart, but the controller never returned it. Now it does.

```php
// Before
return response()->json(['message' => 'Item added to cart']);

// After
$cartCount = $this->getCartData()->sum(fn ($item) => $item->quantity ?? 1);
return response()->json(['message' => 'Item added to cart', 'cart_count' => $cartCount]);
```

### primaryImage Eager Loading

Cart items were loaded with `product` but not `product.primaryImage`. The cart drawer JS tries to render `item.product.primaryImage?.image_path`, which was always null.

```php
// Before
return $cart->items()->with('product', 'variant')->get();

// After
return $cart->items()->with('product.primaryImage', 'variant')->get();
```

---

## 3. ProductController.php — Already Correct

The controller was already passing `$relatedProducts`, loading all needed relationships, and using route model binding with `getRouteKeyName()` returning `slug`. No changes needed here.

---

## 4. Pint Formatting

Ran `vendor/bin/pint --dirty --format agent` — all files passed with no formatting issues.

---

## Files Modified

- `resources/views/product_detail.blade.php`
- `app/Http/Controllers/CartController.php`

## Files Reviewed (No Changes Needed)

- `app/Http/Controllers/ProductController.php`
- `app/Models/Product.php`
- `app/Models/ProductVariant.php`
- `app/Models/ProductAttribute.php`
- `app/Models/ProductImage.php`
- `app/Models/Cart.php`
- `app/Models/CartItems.php`
- `database/migrations/2026_05_04_221255_create_products_table.php`
- `database/migrations/2026_05_04_221329_create_product_variants_table.php`
- `database/migrations/2026_05_04_221331_create_product_attributes_table.php`
- `database/migrations/2026_05_04_221332_create_product_images_table.php`
