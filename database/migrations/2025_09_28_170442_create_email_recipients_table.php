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
        Schema::create('email_recipients', function (Blueprint $t) {
            $t->id();
            $t->foreignId('email_id')->constrained('emails')->cascadeOnDelete();
            $t->string('recipient_email');
            $t->string('status')->default('queued');
            $t->string('brevo_message_id')->nullable();
            $t->unsignedInteger('open_count')->default(0);
            $t->timestamp('delivered_at')->nullable();
            $t->timestamp('opened_at')->nullable();
            $t->timestamp('clicked_at')->nullable();
            $t->json('last_response')->nullable();
            $t->timestamps();
            $t->index('brevo_message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_recipients');
    }
};
