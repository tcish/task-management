<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_permissions', function (Blueprint $table) {
            $table->id();
            $table->boolean("can_assign")->default(0);
            $table->boolean("can_create")->default(0);
            $table->integer('permit_to')->unsigned();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('permit_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_permissions');
    }
};
