<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('desc')->nullable();
            $table->integer('views_count')->default(1);
            $table->string('price')->nullable();
            $table->string('discount_price')->nullable();
            $table->text('info')->nullable();
            $table->bigInteger('brand_id')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('slug');
            $table->string('status');
            $table->text('date')->nullable();
            $table->text('groupsize')->nullable();
            $table->text('language')->nullable();
            $table->text('map')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
