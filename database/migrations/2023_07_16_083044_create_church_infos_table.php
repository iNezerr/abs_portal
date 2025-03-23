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
        Schema::create('church_infos', function (Blueprint $table) {
            $table->id();
            $table->string('is_born_again');
            $table->string('is_called');
            $table->text('explain_calling');
            $table->string('church');
            $table->string('role_in_church');
            $table->integer('duration_of_service');
            $table->text('history_before_born_again');
            $table->text('history_of_present_church');
            $table->text('history_of_roles_in_church');
            $table->text('reason_for_coming_to_bible_school');
            $table->foreignId('applicant_id')->constrained('applicants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_infos');
    }
};
