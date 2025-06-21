<?php

use App\Models\Employee;
use App\Models\ServiceSubCategory;
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
        Schema::create('employee_service_sub_category', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(Employee::class);
            // $table->foreignIdFor(ServiceSubCategory::class);
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('service_sub_category_id')->nullable()->constrained('service_sub_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_service_sub_category');
    }
};
