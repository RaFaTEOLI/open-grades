<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class CreateStudentsClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("students_classes", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("class_id");
            $table->bigInteger("presence")->default(0);
            $table->bigInteger("absent")->default(0);
            $table->timestamp("enroll_date")->default(Carbon::today());
            $table->timestamp("left_date")->nullable();
            $table->unique('user_id', 'class_id');

            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users");
            $table
                ->foreign("class_id")
                ->references("id")
                ->on("classes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("students_classes");
    }
}
