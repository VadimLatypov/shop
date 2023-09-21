<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->mediumText('anons');
            $table->longText('text');
            $table->integer('price');
            $table->string('category');
            $table->string('img_main');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
