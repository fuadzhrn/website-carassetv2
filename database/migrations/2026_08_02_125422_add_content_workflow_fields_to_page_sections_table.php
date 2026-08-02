<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Purely additive — content/is_active/updated_by/timestamps on
     * page_sections are untouched. Every existing row becomes
     * workflow_status = 'published' with published_at/published_by left
     * null (their real first Publish through this new workflow hasn't
     * happened yet — never backfilled with a guessed timestamp/admin).
     */
    public function up(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->string('workflow_status')->default('published')->after('is_active');
            $table->json('draft_content')->nullable()->after('workflow_status');
            $table->boolean('draft_is_active')->nullable()->after('draft_content');
            $table->timestamp('draft_updated_at')->nullable()->after('draft_is_active');
            $table->timestamp('published_at')->nullable()->after('draft_updated_at');
            $table->foreignId('published_by')->nullable()->after('published_at')->constrained('users')->nullOnDelete();

            $table->index('workflow_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_sections', function (Blueprint $table) {
            $table->dropConstrainedForeignId('published_by');
            $table->dropIndex(['workflow_status']);
            $table->dropColumn(['workflow_status', 'draft_content', 'draft_is_active', 'draft_updated_at', 'published_at']);
        });
    }
};
