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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('license_no')->unique();
            $table->date('license_expiry');
            $table->string('address')->nullable();
            $table->enum('status',[
                'active',
                'expired',
                'suspended',
            ])->default('active');
            $table->timestamps();
            $table->softDeletes(); // Add this line for soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
