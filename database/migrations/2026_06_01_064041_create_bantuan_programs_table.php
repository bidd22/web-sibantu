<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bantuan_programs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->text('deskripsi');
            $table->integer('kuota');
            $table->date('deadline');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bantuan_programs');
    }
};