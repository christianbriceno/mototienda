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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('order_id')->constrained('orders');

            $table->string('issuer_rif');
            $table->string('issuer_name');
            $table->string('issuer_address');
            $table->string('issuer_phone_number');
            $table->string('issuer_email');

            $table->string('receiver_rif')->nullable();
            $table->string('receiver_identification_card')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_address')->nullable();
            $table->string('receiver_phone_number')->nullable();
            $table->string('receiver_email')->nullable();

            $table->float('amount_iva')->nullable()->default(0);
            $table->float('total_with_iva')->nullable()->default(0);
            $table->float('total_without_iva')->nullable()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
