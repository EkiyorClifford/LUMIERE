# LUMIÈRE storefront link & route audit

Pick **IDs** to fix. Paths are repo-relative.

---

## A. Data / wrong route target

| ID | Issue | Where | Notes |
|----|--------|-------|--------|
| A1 | `collections.show` **`la-nuit`** | Footer/marketing (e.g. `collections.blade.php`) | `DatabaseSeeder` only has `leclat`, `lor`, `la-perle` — **404** until row exists. |
| A2 | **`collections.show`** used with **category** slugs (`necklaces`, `rings`, …) | `resources/views/size-guide.blade.php` footer | Use `route('shop', ['category' => 'necklace'])` etc. Seeder categories: `necklace`, `ring`, `earrings`, `bracelet`, `bangle`. |

---

## B. Static prototype URLs

| ID | Issue | Where |
|----|--------|--------|
| B1 | `lumiere.html`, `contact.html` | `resources/views/wishlist.blade.php` |
| B2 | `lespace.html` | `resources/views/sur-mesure.blade.php` |

---

## C. Journal

| ID | Issue | Notes |
|----|--------|--------|
| C1 | `/journal` → **`editorial.blade.php`** (dynamic) | `PostController@index` |
| C2 | **`journal.blade.php`** demo grid, many **`href="#"`** | Not default route unless changed; wire or retire. |

---

## D. `href="#"` placeholders (by area)

**D1 Social:** `welcome.blade.php`, `collections.blade.php`, `journal.blade.php`, `editorial.blade.php`, `post-detail.blade.php`, `product_detail.blade.php`, `atelier.blade.php`, `size-guide.blade.php`, `wishlist.blade.php`

**D2 Collections CTAs:** `collections.blade.php` (explore / section buttons)

**D3 Size guide sizer row:** `size-guide.blade.php` — printable + free kit buttons still `#`

**D4 Journal demo links:** `journal.blade.php`

**D5 Post share:** `post-detail.blade.php`

**D6 Legal:** `auth/register.blade.php`, `bespoke.blade.php`, `checkout.blade.php`

**D7 Checkout:** `checkout.blade.php` — e.g. “TRACK MY ORDER”

**D8 Product:** `product_detail.blade.php` — “Notify me”

**D9 L’Espace:** `lespace.blade.php` — booking / track placeholders

**D10 Errors:** `errors/403.blade.php`

---

## E. Routes snapshot (storefront)

Sanity: `home`, `shop`, `collections`, `collections.show`, `product.show`, `cart.index`, `journal`, `post.show`, `post.category`, `contact`, `faq`, `shipping`, `size-guide`, `newsletter`, `concierge.request`, `sizer-kit.request`, `wishlist.*` — confirm with `php artisan route:list`.

---

_Re-run this audit after large route or seeder changes._
