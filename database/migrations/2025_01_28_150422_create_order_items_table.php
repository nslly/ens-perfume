<?php

use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->onDelete('cascade'); 
            $table->foreignIdFor(Product::class)->onDelete('cascade'); 
            $table->unsignedInteger('quantity');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
