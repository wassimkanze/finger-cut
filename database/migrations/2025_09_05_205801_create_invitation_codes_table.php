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
        Schema::create('invitation_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('email')->nullable(); // Email spécifique si nécessaire
            $table->string('role')->default('employé'); // Rôle assigné
            $table->boolean('used')->default(false);
            $table->foreignId('created_by')->constrained('users'); // Qui a créé le code
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['code', 'used']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_codes');
    }
};