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
        Schema::table('pages', function (Blueprint $table) {
            // Published SEO fields. meta_title/meta_description already
            // exist (PROMPT 15) and are left untouched.
            $table->string('meta_robots')->nullable()->after('meta_description');
            $table->text('canonical_url')->nullable()->after('meta_robots');

            // Draft SEO fields — mirror of PROMPT 23's page_sections
            // draft_content/draft_is_active pattern, scoped to metadata only.
            $table->string('draft_meta_title')->nullable()->after('canonical_url');
            $table->text('draft_meta_description')->nullable()->after('draft_meta_title');
            $table->string('draft_meta_robots')->nullable()->after('draft_meta_description');
            $table->text('draft_canonical_url')->nullable()->after('draft_meta_robots');

            // Workflow metadata — plain string status (not a DB enum), same
            // convention as page_sections.workflow_status.
            $table->string('seo_workflow_status')->default('published')->after('draft_canonical_url');
            $table->timestamp('seo_draft_updated_at')->nullable()->after('seo_workflow_status');
            $table->timestamp('seo_published_at')->nullable()->after('seo_draft_updated_at');
            $table->foreignId('seo_updated_by')->nullable()->after('seo_published_at')->constrained('users')->nullOnDelete();
            $table->foreignId('seo_published_by')->nullable()->after('seo_updated_by')->constrained('users')->nullOnDelete();

            $table->index('seo_workflow_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('seo_published_by');
            $table->dropConstrainedForeignId('seo_updated_by');

            $table->dropColumn([
                'meta_robots',
                'canonical_url',
                'draft_meta_title',
                'draft_meta_description',
                'draft_meta_robots',
                'draft_canonical_url',
                'seo_workflow_status',
                'seo_draft_updated_at',
                'seo_published_at',
            ]);
        });
    }
};
