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
        Schema::create('package_details', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->default(0);
            $table->integer('price_sale')->nullable();
            $table->integer('number_file')->default(0);
            $table->integer('expire')->nullable(); // by number of month
            // $table->string('website_id')->nullable(); // id website
            // $table->string('description')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_details');
    }
};
