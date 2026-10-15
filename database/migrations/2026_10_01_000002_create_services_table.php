<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->string('service_code', 12)->unique();
            $table->string('package_name');
            $table->unsignedInteger('bandwidth_mbps');
            $table->unsignedInteger('monthly_price');
            $table->enum('status', ['active', 'isolated', 'terminated'])->default('active')->index();
            $table->dateTime('activated_at');
            $table->dateTime('terminated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
