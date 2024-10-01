<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voles', function (Blueprint $table) {
            $table->id();
            $table->string('ville');
            $table->foreign('destination_id')->references('id')->on('destinations');
            $table->string('description');
            $table->date('du');
            $table->date('au');
            $table->string('prix');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('voles');
    }
};
