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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('price')->default(0);
            $table->integer('price_sale')->nullable();
            $table->integer('number_file')->default(0);
            // $table->string('number_download')->default(1);
            // $table->string('file_per_day')->default(1);
            $table->string('type')->nullable(); // day,month,year
            $table->integer('expire')->nullable(); // by number of month
            $table->string('website_id')->nullable(); // id website
            $table->string('avatar')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
