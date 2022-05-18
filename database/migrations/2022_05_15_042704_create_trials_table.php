<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trials', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->decimal('refund', 10, 2)->default(0);
            $table->decimal('ship_fee', 10, 2)->default(0);
            $table->integer('clicks')->default(0);
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('seller_id')->references('id')->on('sellers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trials');
    }
}
