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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            // String, bukan integer — nomor boleh berawalan + atau 0.
            $table->string('whatsapp', 30);
            $table->string('email')->nullable();
            // Value internal dari CMS (form.program_options.*.value), bukan label.
            $table->string('program');
            $table->text('message');

            $table->boolean('consent')->default(false);
            $table->timestamp('consented_at')->nullable();

            // String biasa (bukan enum database) — lihat konstanta
            // ContactMessage::STATUS_*.
            $table->string('status')->default('new');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();

            // Hanya diisi bila config('contact-form.privacy.*') mengaktifkannya.
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
            $table->index('program');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
