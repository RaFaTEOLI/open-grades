<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsResponsibleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("students_responsible", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("responsible_id");
            $table->unsignedBigInteger("student_id");
            $table->timestamps();
            $table
                ->foreign("responsible_id")
                ->references("id")
                ->on("users");
            $table
                ->foreign("student_id")
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
        Schema::dropIfExists("students_responsible");
    }
}
