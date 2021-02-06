<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaravelEntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Schema to create roles table
        Schema::create("roles", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name")->unique();
            $table->string("display_name")->nullable();
            $table->string("description")->nullable();
            $table->timestamps();
        });

        // Schema to create permissions table
        Schema::create("permissions", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name")->unique();
            $table->string("display_name")->nullable();
            $table->string("description")->nullable();
            $table->timestamps();
        });

        // Schema to create role_users table
        Schema::create("role_user", function (Blueprint $table) {
            $table->unsignedBigInteger("role_id");
            $table->unsignedBigInteger("user_id");

            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table
                ->foreign("role_id")
                ->references("id")
                ->on("roles")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->primary(["user_id", "role_id"]);
        });

        // Schema to create permission_role table
        Schema::create("permission_role", function (Blueprint $table) {
            $table->unsignedBigInteger("permission_id");
            $table->unsignedBigInteger("role_id");

            $table
                ->foreign("permission_id")
                ->references("id")
                ->on("permissions")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table
                ->foreign("role_id")
                ->references("id")
                ->on("roles")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->primary(["permission_id", "role_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists("permission_role");
        Schema::dropIfExists("role_user");
        Schema::dropIfExists("permissions");
        Schema::dropIfExists("roles");
    }
}
