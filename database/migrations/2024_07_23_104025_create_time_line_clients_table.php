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
        Schema::create('time_line_clients', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('lead')->nullable();
            $table->string('date')->nullable();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('timeline_clients', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
        });
        Schema::dropIfExists('timeline_clients');
    }
};
