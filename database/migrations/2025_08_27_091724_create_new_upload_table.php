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
        Schema::create('membership_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('letter')->nullable();
            $table->string('constitution')->nullable();
            $table->string('activities')->nullable();
            $table->string('funding')->nullable();
            $table->string('registration')->nullable();
            $table->string('strategic_plan')->nullable();
            $table->string('fundraising_strategy')->nullable();
            $table->string('audit_report')->nullable();
            $table->string('goal')->nullable();
            $table->longText('signature')->nullable(); // base64 string or file path
            $table->timestamps();
        });

        // membership_networks table
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_upload_id')->constrained()->onDelete('cascade');
            $table->string('network_name');
            $table->timestamps();
        });

        // membership_focal_points table
        Schema::create('focal_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_upload_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('membership_uploads');
        Schema::dropIfExists('networks');
        Schema::dropIfExists('focal_points');
    }
};
