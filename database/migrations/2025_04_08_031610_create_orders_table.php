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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('client_id')->constrained('clients');

            $table->string('payment_method');
            $table->float('exchange_rate');
            $table->float('amount_iva');

            $table->float('total_price_usd')->nullable();
            $table->float('total_price_usd_without_iva')->nullable();

            $table->float('total_price_bs')->nullable();
            $table->float('total_price_bs_without_iva')->nullable();

            $table->float('total_cost_usd')->nullable();
            $table->float('total_cost_bs')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
