<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('jarmuvek', function (Blueprint $table) {

        $table->id();

        $table->foreignId('ceg_id')
              ->constrained('cegek')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();

        $table->string('kategoria', 50);

        $table->string('marka', 50);

        $table->string('tipus', 50);

        $table->integer('tengelyszam');

        $table->string('rendszam', 20)->unique();

        $table->string('vin', 30)->nullable();

        $table->string('euro_besorolas', 10)->nullable();

        $table->integer('ossztomeg_kg')->nullable();

        $table->boolean('potkocsi_kepes')->default(false);

        $table->foreignId('device_id')
              ->nullable()
              ->constrained('trackereszkozok')
              ->nullOnDelete();

        $table->boolean('aktiv')->default(true);

        $table->timestamp('created_at')->useCurrent();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('jarmuvek');
    }
};
