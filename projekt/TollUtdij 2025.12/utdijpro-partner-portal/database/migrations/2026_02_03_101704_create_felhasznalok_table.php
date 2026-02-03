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
    Schema::create('felhasznalok', function (Blueprint $table) {

        $table->id();
        $table->foreignId('ceg_id')
              ->nullable()
              ->constrained('cegek')
              ->nullOnDelete();
        $table->string('email', 255)->unique();
        $table->string('jelszo_hash', 255);
        $table->string('teljes_nev', 255)->nullable();
        $table->boolean('aktiv')->default(true);
        $table->timestamp('created_at')->useCurrent();
        $table->enum('role', [
            'rendszer_admin',
            'ceg_admin',
            'operator'
        ])->default('operator');
        $table->timestamp('email_verified_at')->nullable();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('felhasznalok');
    }
};
