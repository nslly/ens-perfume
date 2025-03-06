<?php

use App\Models\Brand;
use App\Models\Product\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->foreignIdFor(Category::class)->onDelete('cascade');
            $table->foreignIdFor(Brand::class)->onDelete('cascade');
            $table->text('description');
            $table->unsignedInteger('volume');
            $table->unsignedInteger('quantity');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->json('images')->nullable();
            $table->tinyInteger('gender');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
