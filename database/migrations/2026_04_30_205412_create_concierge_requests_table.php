<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('concierge_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject'); // e.g. "Bracelet sizing", "Ring sizing", "Gift sizing"
            $table->string('piece')->nullable(); // the specific product if known
            $table->string('measurement')->nullable(); // nullable string
            $table->string('message')->nullable();
            $table->enum('status', ['pending', 'replied', 'resolved'])->default('pending');
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();         // they might give it later
            $table->enum('source', [
                'newsletter_footer',
                'newsletter',       // footer signup
                'collections',      // collections page CTA
                'la_nuit_notify',   // "notify me" on coming soon
                'checkout',         // opted in during purchase
                'size_guide',       // from size guide page
            ])->default('newsletter_footer');
            $table->enum('status', [
                'active',
                'unsubscribed',
                'bounced',
            ])->default('active');
            $table->string('unsubscribe_token')->unique(); // for one-click unsubscribe links
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concierge_requests');
        Schema::dropIfExists('subscribers');
    }
};
