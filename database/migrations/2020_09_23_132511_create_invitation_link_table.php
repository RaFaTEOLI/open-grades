<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("invitation_links", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->text("hash");
            $table->string("type");
            $table->unsignedBigInteger("student_id")->nullable;
            $table->timestamp("used_at")->nullable();
            $table->timestamps();

            $table
                ->foreign("user_id")
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
        Schema::dropIfExists("invitation_links");
    }
}
