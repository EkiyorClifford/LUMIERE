<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      // 1. Convert Products to secure integer cents and add Indexes
        if (!Schema::hasColumn('products', 'price_cents')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('price_cents')->default(0)->after('price');
                $table->index(['is_active', 'sort_order']); // For instant listings queries
            });
        }

        // 2. Convert Product Variants to integer cents
        Schema::table('product_variants', function (Blueprint $table) {
            $table->integer('price_modifier_cents')->default(0)->after('price_modifier');
            $table->index('product_id'); // Lock efficiency index
        });

        // 3. Upgrade Orders with direct address snapshotting & checkout tokens
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('total_cents')->default(0)->after('total');
            $table->string('stripe_payment_intent_id')->nullable()->unique()->after('order_number');

            // Historical Address snapshotting guarantees address revisions do not damage history
            $table->text('historical_address_snapshot')->nullable()->after('shipping_country');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_cents']);
            $table->dropIndex(['is_active', 'sort_order']);
            $table->dropUnique(['slug']);
        });

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['price_modifier_cents']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total_cents', 'stripe_payment_intent_id', 'historical_address_snapshot']);
        });
    }
};
