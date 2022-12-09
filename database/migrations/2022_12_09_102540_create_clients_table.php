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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->timestamp('address');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('pwd');
            $table->boolean('isClient')->default('true');
            $table->integer('veterinary_id')->unsigned()->index()->nullable();
            $table->foreign('veterinary_id')->references('id')->on('veterinaire')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('clients');
    }
};
