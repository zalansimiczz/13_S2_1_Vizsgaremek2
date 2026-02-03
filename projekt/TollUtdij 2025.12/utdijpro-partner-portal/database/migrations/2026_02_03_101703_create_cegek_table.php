<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('cegek', function (Blueprint $table) {

        $table->id();

        $table->string('nev', 255);

        $table->string('adoszam', 50)->nullable();

        $table->string('cim', 255)->nullable();

        $table->string('statusz', 50)->nullable();

        $table->timestamp('created_at')->nullable()->useCurrent();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('cegek');
    }
};
