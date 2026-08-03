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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // e.g. content.draft_saved, content.published, seo.published,
            // media.uploaded — never a full JSON payload, never a raw URL.
            $table->string('event');
            $table->string('page_slug')->nullable();
            $table->string('section_key')->nullable();
            $table->foreignId('causer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index('event');
            $table->index('page_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
