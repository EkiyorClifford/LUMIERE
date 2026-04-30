# Migration Changes Comparison

**File:** `database/migrations/0001_01_01_000000_create_users_table.php`

## Summary

This migration has been significantly enhanced to support a luxury e-commerce platform with VIP customer management, bespoke jewelry projects, and content management features.

---

## Major Additions

### 1. New Tables Added

#### **consultants** (Lines 197-206)
- Staff/consultant management for personalized luxury service
- Fields: name, title, location, bio, avatar_path, is_active
- Purpose: Assign dedicated consultants to VIP customers

#### **treasures** (Lines 217-227)
- Customer's owned jewelry collection ("The Vault")
- Supports both online purchases and offline-registered items
- Fields: serial_number, custom_name, certificate_path, purchased_at
- Links to user, product (optional), and order_item (optional)

#### **bespoke_projects** (Lines 230-240)
- Custom jewelry project tracking (e.g., "La Nuit Noir")
- Workflow stages: consultation → sketching → wax_model → setting → polishing → finished
- Fields: project_title, estimated_budget, current_step, sketch_image_path, internal_notes
- Links to user and assigned consultant

#### **appointments** (Lines 243-251)
- Appointment scheduling system
- Types: atelier_paris, virtual_consultation, bespoke_review
- Status workflow: requested → confirmed → completed → cancelled
- Links to user and consultant

#### **posts** (Lines 254-266)
- Content management for "The Journal"
- Fields: title, slug, category, volume_label, excerpt, content, featured_image
- Publishing workflow with is_published and published_at

### 2. Users Table Extensions (Lines 209-213)

Added columns to existing `users` table:
- `consultant_id` - Foreign key to consultants table (nullable)
- `membership_tier` - Enum: standard, gold_circle, platinum_inner
- `private_notes` - Text field for consultant notes on VIP customers

### 3. Soft Deletes (Lines 268-283)

Added soft deletes to:
- users
- products
- orders
- product_attributes
- reviews

---

## Minor Improvements

### Code Quality & Documentation

- **Comment formatting:** Standardized comment spacing (e.g., "//shipping" → "// shipments")
- **Inline comments:** Added explanatory comments for complex fields
  - `payment_reference`: "external transaction ID from gateway"
  - `gateway_response`: "raw webhook payload for dispute resolution"
  - `shipping_method`: "standard, express, overnight"
  - `carrier`: "DHL, FedEx, etc."
  - `is_verified_purchase`: "set true after confirmed delivery"
  - `is_approved`: "moderation before going live"

### Foreign Key Constraints

- **shipments.order_id:** Changed from `nullOnDelete()` to `cascadeOnDelete()`
- **reviews.user_id & product_id:** Added explicit `nullable()` before `constrained()`

### Down Method Improvements (Lines 289-312)

- Added proper dependency-aware drop order
- New tables dropped first (appointments, bespoke_projects, treasures)
- Added posts table to drop sequence
- Consultants dropped last (no dependencies)
- Improved comment documentation

---

## Deleted/Removed

- No tables were removed
- Only formatting and constraint refinements

---

## Impact Assessment

### Database Size
- **New tables:** 5 additional tables
- **New columns:** 3 columns on users table
- **Soft deletes:** 5 tables now include deleted_at timestamps

### Functionality
- **VIP Management:** Full support for tiered membership and dedicated consultants
- **Custom Projects:** End-to-end bespoke jewelry workflow tracking
- **Appointments:** In-person and virtual consultation scheduling
- **Content:** Blog/journal publishing system
- **Vault:** Customer jewelry registry independent of purchase channel

### Breaking Changes
- **None** - All changes are additive
- Migration is backward compatible (only adds tables/columns)
