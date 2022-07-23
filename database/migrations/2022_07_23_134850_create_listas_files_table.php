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
        Schema::create('listas_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listas_id');
            $table->string('url',500);
            $table->string('name');
            $table->boolean('state')->default(true);
            $table->timestamps();
            $table->foreign('listas_id','listas_files_listas_id_fk')->references('id')->on('listas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listas_files');
    }
};
