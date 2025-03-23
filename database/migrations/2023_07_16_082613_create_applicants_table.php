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
        Schema::create('applicants', function (Blueprint $table) {

            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('postal_address');
            $table->string('country');
            $table->string('contact');
            $table->string('email_address');
            $table->string('residence');
            $table->string('next_of_kin');
            $table->string('next_of_kin_contact');
            $table->string('profession');
            $table->string('name_of_father');
            $table->string('profession_of_father');
            $table->string('name_of_mother');
            $table->string('profession_of_mother');
            $table->string('name_of_guardian');
            $table->string('profession_of_guardian');
            $table->string('is_parent_or_guardian_owning_house');
            $table->string('is_parent_or_guardian_renting_house');
            $table->string('is_parent_or_guardian_business_owner');
            $table->string('is_parent_or_guardian_car_owner');
            $table->string('name_of_travel_sponsor');
            $table->string('name_of_benefactor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
