<?php

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
        Schema::create('perfume_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->onDelete('cascade');
            $table->string('type'); 
            $table->string('name'); 
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfume_notes');
    }
};
