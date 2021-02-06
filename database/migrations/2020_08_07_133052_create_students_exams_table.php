<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("students_exams", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("exam_id");
            $table->double("weight", 15, 8);
            $table->timestamps();

            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");
            $table
                ->foreign("exam_id")
                ->references("id")
                ->on("exams");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("students_exams");
    }
}
