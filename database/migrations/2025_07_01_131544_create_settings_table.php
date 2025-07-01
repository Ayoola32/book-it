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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('bname');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('currency')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->json('social')->nullable();
            $table->string('copyright')->nullable();
            $table->string('powered_by')->nullable();
            $table->string('footer_info')->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->longText('map')->nullable();
            $table->json('other')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
