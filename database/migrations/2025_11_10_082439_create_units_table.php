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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->string('code');
            $table->unsignedBigInteger('base_unit')->nullable();
            $table->string('operator');
            $table->decimal('operation_value');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('base_unit')->references('id')->on('units');

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIfExists('units');
        });
    }
};
