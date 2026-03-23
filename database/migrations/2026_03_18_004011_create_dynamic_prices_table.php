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
        Schema::create('dynamic_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('base_price', 10, 2);
            $table->decimal('dynamic_price', 10, 2);
            $table->string('reason');
            $table->json('factors')->nullable();
            $table->decimal('occupancy_rate', 5, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['property_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_prices');
    }
};
