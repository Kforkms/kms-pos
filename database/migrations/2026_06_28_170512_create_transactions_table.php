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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shift_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name')->nullable();
            $table->enum('order_type', ['dine_in', 'takeaway', 'online'])->default('dine_in');
            $table->integer('total_amount');
            $table->integer('discount')->default(0);
            $table->enum('payment_method', ['cash', 'qris']);
            $table->integer('paid_amount');
            $table->integer('change_amount');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
