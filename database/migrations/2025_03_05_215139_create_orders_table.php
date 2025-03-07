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
            $table->foreignId('user_id')->constrained('users');
            // $table->foreignId('payment_method_id')->nullable()->constrained('payments', 'payment_method'); // Car cart
            $table->integer('total_price_without_tax');
            $table->integer('total_price_with_tax');
            $table->integer('tax_amount');
            $table->enum('status', ['cart', 'pending', 'completed', 'shipped', 'cancelled']);
            $table->json('address')->nullable();
            $table->timestamps();
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
