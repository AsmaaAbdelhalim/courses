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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();            
            $table->longtext('description')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('requirement')->nullable();
            $table->integer('price')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('numOfHours')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->string('duration')->nullable();
            //$table->string('rate')->nullable();
            $table->string('image')->nullable();
            $table->string('files')->nullable();
            $table->string('videos')->nullable();
            $table->text('session')->nullable();
            //$table->string('category')->nullable();
            //$table->string('lessons')->nullable();
            $table->integer('status')->nullable();
            $table->string('level')->nullable();
            $table->string('teachers')->nullable();
            $table->string('language')->nullable();

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            //$table->unsignedBigInteger('enrollment_id')->nullable();
            //$table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
