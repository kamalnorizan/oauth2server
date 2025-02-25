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
        Schema::create('sub_sys_scopes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sub_system_id')->unsigned();
            $table->foreign('sub_system_id')->references('id')->on('sub_systems')->onDelete('restrict')->onUpdate('cascade');
            $table->string('scope', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_sys_scopes');
    }
};
