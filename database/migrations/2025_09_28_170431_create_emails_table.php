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
        Schema::create('emails', function (Blueprint $t) {
            $t->id();

            $t->string('subject');
            $t->string('title')->nullable();
            $t->text('html');
            $t->string('button_text')->nullable();
            $t->string('button_url')->nullable();
            $t->string('sender_name');
            $t->string('sender_email');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
