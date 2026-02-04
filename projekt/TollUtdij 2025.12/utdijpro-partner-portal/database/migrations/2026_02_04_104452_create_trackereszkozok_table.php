<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('trackereszkozok', function (Blueprint $table) {

        $table->id();

        $table->string('imei', 20)->unique();

        $table->string('sim_iccid', 25);

        $table->string('modell', 50)->nullable();

        $table->string('firmware_verzio', 50)->nullable();

        $table->boolean('aktiv')->default(true);

        $table->timestamp('created_at')->useCurrent();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('trackereszkozok');
    }
};
