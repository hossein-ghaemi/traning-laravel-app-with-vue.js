<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('relation_id')->index();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('relational_table')->index();
            $table->string('file_name');
            $table->string('file_format');
            $table->string('file_path');
            $table->timestamps();
        });

        Schema::create('file_infos', function (Blueprint $table) {
            $table->id()->references('id')->on('files');
            $table->text('alt')->nullable();
            $table->text('description')->nullable();
            $table->text('title')->nullable();
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
        Schema::dropIfExists('files');
        Schema::dropIfExists('file_infos');
    }
};
