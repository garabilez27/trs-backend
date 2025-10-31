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
        Schema::create('tbl_products', function (Blueprint $table) {
            $table->id('prod_id');
            $table->string('prod_name');
            $table->text('prod_description')->nullable();
            $table->decimal('prod_price',8 ,2);
            $table->unsignedInteger('prod_quantity');
            $table->unsignedTinyInteger('prod_deleted')->default(0);
            $table->timestamp('prod_created_at')->useCurrent();
            $table->timestamp('prod_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_products');
    }
};
