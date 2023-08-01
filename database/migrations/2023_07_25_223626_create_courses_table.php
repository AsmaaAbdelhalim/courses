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
            $table->integer('numOfHours')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->string('duration')->nullable();
            $table->string('rate')->nullable();
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->text('session')->nullable();
            $table->string('category')->nullable();
            $table->string('lessons')->nullable();
            $table->jsonb('meta')->nullable();
          
            


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
