<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptocurrencyPricesTable extends Migration
{
    public function up()
    {
        Schema::create('cryptocurrency_prices', function (Blueprint $table) {
            $table->id();
            $table->string('coin');
            $table->float('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cryptocurrency_prices');
    }
}
