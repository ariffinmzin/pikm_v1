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
        Schema::create('guards', function (Blueprint $table) {
            $table->id();
            $table->char('nric_hash', 64)->comment('SHA-256 of NRIC');
            $table->binary('nric_cipher')->nullable()->comment('AES-256 encrypted NRIC');
            $table->char('nric_last4', 4)->comment('for quick lookup');
            $table->string('full_name', 128);
            $table->date('dob')->nullable();
            $table->string('photo_path', 255)->nullable();
            $table->string('contact_no', 25)->nullable();
            $table->string('email', 128)->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->char('blood_type', 3)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique('nric_hash', 'key_uq_guard_nric');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guards');
    }
};
