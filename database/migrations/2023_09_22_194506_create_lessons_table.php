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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('duration')->nullable();
            //$table->string('difficulty')->nullable();
            $table->longText('content')->nullable();
            $table->string('files')->nullable();
            $table->string('links')->nullable();
            $table->string('videos')->nullable();
            $table->string('audios')->nullable();
            $table->string('images')->nullable();
            //$table->string('audio')->nullable();
            //$table->string('pdf')->nullable();
            $table->text('session')->nullable();
            $table->text('summary')->nullable();
            //$table->string('slug')->unique();

            $table->integer('position')->nullable()->unsigned();
            
            
            $table->timestamp('published_at')->nullable();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //$table->unsignedBigInteger('course_id');
           // $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
