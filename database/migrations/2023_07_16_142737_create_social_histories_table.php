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
        Schema::create('social_histories', function (Blueprint $table) {
            $table->id();
            $table->string('use_narcotics_currently');
            $table->tinyText('current_narcotics_history');
            $table->string('use_narcotics_in_past');
            $table->tinyText('past_narcotics_history');
            $table->string('have_been_arrested_before');
            $table->tinytext('arrest_history');
            $table->string('have_been_prosecuted_before');
            $table->tinytext('prosecution_history');
            $table->string('have_been_jailed_before');
            $table->tinytext('jail_history');
            $table->string('is_taking_alcohol');
            $table->tinytext('alcohol_history');
            $table->string('use_alcohol_in_past');
            $table->tinyText('past_alcohol_history');
            $table->string('have_been_involved_in_robbery');
            $table->tinytext('past_robbery_history');
            $table->string('have_been_a_rebel');
            $table->tinytext('past_rebelious_history');
            $table->string('have_been_in_prostitution');
            $table->tinytext('past_prostitution_history');
            $table->string('vices');
            $table->string('is_virgin');
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_histories');
    }
};
