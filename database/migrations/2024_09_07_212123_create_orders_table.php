<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); // ID của người dùng đặt đơn hàng
            $table->decimal('total_amount', 10, 2); // Tổng số tiền của đơn hàng
            $table->string('status'); // Trạng thái đơn hàng (ví dụ: 'Pending', 'Completed', 'Shipped')
            $table->text('shipping_address'); // Địa chỉ giao hàng
            $table->text('billing_address')->nullable(); // Địa chỉ thanh toán (nếu khác địa chỉ giao hàng)
            $table->unsignedBigInteger('order_status_id'); // ID của trạng thái đơn hàng
            $table->dateTime('date_create')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade')->onUpdate('cascade');
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
