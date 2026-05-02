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
        Schema::create('commission_requests', function (Blueprint $table) {
            $table->id();

            // User who submitted (logged in required)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('consultant_id')->nullable()->constrained('users')->onDelete('set null');

            // Basic info
            $table->enum('category', ['ring', 'necklace', 'earrings', 'bracelet', 'other']);
            $table->string('occasion')->nullable();
            $table->text('vision')->nullable();

            // Design preferences
            $table->string('metal')->nullable();
            $table->string('stone')->nullable();
            $table->decimal('stone_carat', 5, 2)->nullable();
            $table->json('style_preferences')->nullable(); // ['classic', 'minimalist', etc]

            // Logistics
            $table->string('timeline')->nullable();
            $table->decimal('budget_min', 12, 2)->nullable();
            $table->decimal('budget_max', 12, 2)->nullable();

            // Extras
            $table->string('engraving_text', 40)->nullable();
            $table->json('reference_images')->nullable(); // stored file paths

            // Financials (set by staff later)
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->decimal('deposit_amount', 12, 2)->nullable();
            $table->boolean('deposit_paid')->default(false);

            // Status flow
            $table->enum('status', [
                'draft',
                'submitted',
                'consultation_scheduled',
                'design_phase',
                'revision_needed',
                'approved',
                'production',
                'completed',
                'cancelled',
            ])->default('draft');

            // Tracking
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commision_requests');
    }
};
