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
        Schema::create('study_classes_lectures', function (Blueprint $table) {
            $table->index(['study_class_id', 'lecture_id']);
            $table->bigInteger('study_class_id')->unsigned();
            $table->foreign('study_class_id')->references('id')->on('study_classes')->onDelete('cascade');
            $table->bigInteger('lecture_id')->unsigned();
            $table->foreign('lecture_id')->references('id')->on('lectures')->onDelete('cascade');
            $table->integer('sequence')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_classes_lectures');
    }
};
