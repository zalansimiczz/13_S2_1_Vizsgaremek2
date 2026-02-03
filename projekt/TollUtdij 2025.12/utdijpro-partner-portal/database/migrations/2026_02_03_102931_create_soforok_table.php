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
    Schema::create('soforok', function (Blueprint $table) {

        $table->id();
        $table->foreignId('ceg_id')
              ->nullable()
              ->constrained('cegek')
              ->nullOnDelete();
        $table->string('szemelyi_azonosito', 50)->nullable();
        $table->string('nev', 255);
        $table->date('szuletesi_datum')->nullable();
        $table->string('telefonszam', 50)->nullable();
        $table->string('cim', 255)->nullable();
        $table->string('adoszam', 50)->nullable();
        $table->boolean('aktiv')->default(true);
        $table->timestamp('created_at')->useCurrent();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soforok');
    }
};
