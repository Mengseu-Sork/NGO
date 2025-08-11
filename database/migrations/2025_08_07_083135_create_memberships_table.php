<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('ngo_name')->nullable();          // Make nullable
            $table->string('director_name')->nullable();     // Make nullable
            $table->string('director_phone')->nullable();    // Make nullable
            $table->string('director_email')->nullable();    // Make nullable
            $table->string('alt_name')->nullable();
            $table->string('alt_phone')->nullable();
            $table->string('alt_email')->nullable();
            $table->boolean('membership_status'); // true for yes, false for no
            $table->boolean('more_info')->nullable();  // Make nullable, if not always required
            $table->unsignedBigInteger('user_id'); // Add user_id to link membership to user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('membership_networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->timestamps();
        });

        Schema::create('membership_focal_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->string('name');
            $table->string('sex');
            $table->string('position');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('membership_focal_points');
        Schema::dropIfExists('membership_networks');
        Schema::dropIfExists('memberships');
    }
}
