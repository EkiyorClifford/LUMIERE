<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('concierge_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('concierge_requests', 'source')) {
                $table->string('source')->default('contact_page')->after('message');
            }

            if (! Schema::hasColumn('concierge_requests', 'piece_category')) {
                $table->string('piece_category')->nullable()->after('piece');
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE subscribers MODIFY source VARCHAR(64) NOT NULL DEFAULT 'newsletter_footer'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concierge_requests', function (Blueprint $table) {
            if (Schema::hasColumn('concierge_requests', 'piece_category')) {
                $table->dropColumn('piece_category');
            }

            if (Schema::hasColumn('concierge_requests', 'source')) {
                $table->dropColumn('source');
            }
        });
    }
};
