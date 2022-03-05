<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("student_id")->nullable();
            $table->unsignedBigInteger("class_id")->nullable();
            $table->unsignedBigInteger("reporter_id")->nullable();
            $table->text('description');
            $table->timestamps();

            $table
                ->foreign("student_id")
                ->references("id")
                ->on("users");

            $table
                ->foreign("class_id")
                ->references("id")
                ->on("classes");

            $table
                ->foreign("reporter_id")
                ->references("id")
                ->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warnings');
    }
}
