<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('health_infos', function (Blueprint $table) {
            $table->id();
            $table->string('is_having_medical_condition');
            $table->text('medical_condition')->nullable();
            $table->string('is_on_regular_medication');
            $table->text('medications')->nullable();
            $table->string('has_had_major_surgeries');
            $table->text('surgeries')->nullable();
            $table->string('is_having_allergies');
            $table->text('allergies')->nullable();
            $table->text('diseases_treated')->nullable();
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_infos');
    }
};