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
        Schema::create('order_presentation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('presentation_id')->constrained('presentations');
            $table->tinyInteger('item_line')->nullable();
            $table->tinyInteger('quantity');
            $table->float('unit_price');
            $table->float('unit_price_without_iva')->nullable()->default(0);
            $table->float('sub_total_unit_price');
            $table->float('sub_total_unit_price_without_iva')->nullable()->default(0);
            $table->float('unit_cost')->nullable()->default(0);
            $table->float('sub_total_unit_cost')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_presentation');
    }
};
