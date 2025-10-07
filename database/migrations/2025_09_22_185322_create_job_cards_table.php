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
        Schema::create('job_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_manufacture_id')->nullable();
            $table->unsignedBigInteger('sale_person_id')->nullable();
            $table->string('job_card_no')->nullable();
            $table->string('date')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_plat_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('manu_year')->nullable();
            $table->string('full_car')->nullable();
            $table->string('promo')->nullable();
            $table->string('remarks')->nullable();
            $table->foreign('car_manufacture_id')->references('id')->on('car_manufactures');
            $table->foreign('sale_person_id')->references('id')->on('sales_people');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_cards');
    }
};
