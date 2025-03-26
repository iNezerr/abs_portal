<script setup>
import { ref, onMounted, inject } from "vue";
import { useForm } from "@inertiajs/vue3";

import { trans } from "laravel-vue-i18n";

import InputError from "@/Components/InputError.vue";
import Fileinput from "@/Components/FileInput.vue";

import { useToast } from "primevue/usetoast";
import { useDropzone } from "vue3-dropzone";

import { CountryService } from "../../../services/countryService";
import GuestLayout from "../../../Layouts/GuestLayout.vue";

const formData = inject("formData");
const toast = useToast();

const genders = ref([
    { name: "Male", value: "Male" },
    { name: "Female", value: "Female" },
]);

const settlement = ref([
    { name: "City", value: "City" },
    { name: "Town", value: "Town" },
    { name: "Village", value: "Village" },
    { name: "Slum", value: "Slum" },
]);

const countries = ref();

const maritalStatuses = ref([
    { name: "Single", value: "Single" },
    { name: "Married", value: "Married" },
    { name: "Divorced", value: "Divorced" },
    { name: "Widowed", value: "Widowed" },
]);

const yesNO = ref([
    { name: "Yes", value: "Yes" },
    { name: "No", value: "No" },
]);

const form = useForm({
    first_name: formData?.first_name || "",
    last_name: formData?.last_name || "",
    date_of_birth: formData?.date_of_birth || "",
    gender: formData?.gender || "",
    marital_status: formData?.marital_status || "",
    postal_address: formData?.postal_address || "",
    country: formData?.country || "",
    contact: formData?.contact || "",
    current_work: formData?.current_work || "",
    settlement: formData?.settlement || "",
    email_address: formData?.email_address || "",
    residence: formData?.residence || "",
    next_of_kin: formData?.next_of_kin || "",
    next_of_kin_contact: formData?.next_of_kin_contact || "",
    profession: formData?.profession || "",
    name_of_father: formData?.name_of_father || "",
    profession_of_father: formData?.profession_of_father || "",
    name_of_mother: formData?.name_of_mother || "",
    profession_of_mother: formData?.profession_of_mother || "",
    name_of_guardian: formData?.name_of_guardian || "",
    profession_of_guardian: formData?.profession_of_guardian || "",
    is_parent_or_guardian_owning_house:
        formData?.is_parent_or_guardian_owning_house || "",
    is_parent_or_guardian_renting_house:
        formData?.is_parent_or_guardian_renting_house || "",
    is_parent_or_guardian_business_owner:
        formData?.is_parent_or_guardian_business_owner || "",
    is_parent_or_guardian_car_owner:
        formData?.is_parent_or_guardian_car_owner || "",
    name_of_travel_sponsor: formData?.name_of_travel_sponsor || "",
    name_of_benefactor: formData?.name_of_benefactor || "",
    educational_certificate: formData?.educational_certificate || "",
});

const onFileUpload = async (event) => {
    const files = event;

    form.educational_certificate = files[0];
    console.log(form);
};

const emit = defineEmits(["next-page"]);

const nextPage = () => {
    const pageIndex = 0;

    form.post(route("apply.store-personal-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.first_name = form.first_name;
            formData.last_name = form.last_name;
            formData.date_of_birth = form.date_of_birth;
            formData.gender = form.gender;
            formData.marital_status = form.marital_status;
            formData.postal_address = form.postal_address;
            formData.country = form.country;
            formData.contact = form.contact;
            formData.email_address = form.email_address;
            formData.residence = form.residence;
            formData.next_of_kin = form.next_of_kin;
            formData.next_of_kin_contact = form.next_of_kin_contact;
            formData.profession = form.profession;
            formData.name_of_father = form.name_of_father;
            formData.profession_of_father = form.profession_of_father;
            formData.name_of_mother = form.name_of_mother;
            formData.profession_of_mother = form.profession_of_mother;
            formData.name_of_guardian = form.name_of_guardian;
            formData.profession_of_guardian = form.profession_of_guardian;
            formData.is_parent_or_guardian_owning_house =
                form.is_parent_or_guardian_owning_house;
            formData.is_parent_or_guardian_renting_house =
                form.is_parent_or_guardian_renting_house;
            formData.is_parent_or_guardian_business_owner =
                form.is_parent_or_guardian_business_owner;
            formData.is_parent_or_guardian_car_owner =
                form.is_parent_or_guardian_car_owner;
            formData.name_of_travel_sponsor = form.name_of_travel_sponsor;
            formData.name_of_benefactor = form.name_of_benefactor;
            formData.educational_certificate = form.educational_certificate;

            emit("next-page", { formData, pageIndex });
        },
    });
};

onMounted(async () => {
    CountryService.getCountries().then((data) => (countries.value = data));
    try {
        const response = await fetch(
            route("session.get", { key: "personal_info" })
        );
        if (response.ok) {
            const data = await response.json();

            // Set the form fields with the retrieved data
            Object.keys(data).forEach((key) => {
                form[key] = data[key];
            });
        } else {
            // Handle error if the request is not successful
            console.error("Error fetching data:", response.statusText);
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
});
</script>

<template>
    <section class="">
        <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="first_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("first_name") }}</label
                    >

                    <InputText
                        id="first_name"
                        v-model="form.first_name"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.first_name"
                    />
                </div>
                <div class="md:w-1/2 px-3">
                    <label
                        for="last_name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("last_name") }}</label
                    >

                    <InputText
                        id="last_name"
                        v-model="form.last_name"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.last_name"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="date_of_birth"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("date_of_birth") }}</label
                    >

                    <Calendar
                        id="date_of_birth"
                        v-model="form.date_of_birth"
                        class="w-full"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.date_of_birth"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="gender"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("gender") }}</label
                    >

                    <Dropdown
                        v-model="form.gender"
                        :options="genders"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.gender"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="marital_status"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("marital_status") }}</label
                    >

                    <Dropdown
                        v-model="form.marital_status"
                        :options="maritalStatuses"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.marital_status"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="country"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("country") }}</label
                    >

                    <Dropdown
                        v-model="form.country"
                        :options="countries"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.country"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="contact"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("contact") }}</label
                    >

                    <InputText
                        id="contact"
                        v-model="form.contact"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.contact"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="email_address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("email_address") }}</label
                    >

                    <InputText
                        id="email_address"
                        v-model="form.email_address"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.email_address"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="profession"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("profession") }}</label
                    >

                    <InputText
                        id="profession"
                        v-model="form.profession"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.profession"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="current_work"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("current_work") }}</label
                    >

                    <InputText
                        id="current_work"
                        v-model="form.current_work"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.current_work"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="postal_address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("postal_address") }}</label
                    >

                    <InputText v-model="form.postal_address" class="w-full" />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.postal_address"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="settlement"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("settlement") }}</label
                    >

                    <Dropdown
                        v-model="form.settlement"
                        :options="settlement"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.settlement"
                    />
                </div>
                <div class="md:w-1/2 px-3">
                    <label
                        for="residence"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("residence") }}</label
                    >

                    <Textarea
                        v-model="form.residence"
                        rows="2"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.residence"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="next_of_kin"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("next_of_kin") }}</label
                    >

                    <InputText
                        id="next_of_kin"
                        v-model="form.next_of_kin"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.next_of_kin"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="next_of_kin_contact"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("next_of_kin_contact") }}</label
                    >

                    <InputText
                        id="next_of_kin_contact"
                        v-model="form.next_of_kin_contact"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.next_of_kin_contact"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="name_of_father"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("name_of_father") }}</label
                    >

                    <InputText
                        id="name_of_father"
                        v-model="form.name_of_father"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.name_of_father"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="profession_of_father"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("profession_of_father") }}</label
                    >

                    <InputText
                        id="profession_of_father"
                        v-model="form.profession_of_father"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.profession_of_father"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="name_of_mother"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("name_of_mother") }}</label
                    >

                    <InputText
                        id="name_of_mother"
                        v-model="form.name_of_mother"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.name_of_mother"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="profession_of_mother"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("profession_of_mother") }}</label
                    >

                    <InputText
                        id="profession_of_mother"
                        v-model="form.profession_of_mother"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.profession_of_mother"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="name_of_guardian"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("name_of_guardian") }}</label
                    >

                    <InputText
                        id="name_of_guardian"
                        v-model="form.name_of_guardian"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.name_of_guardian"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="profession_of_guardian"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("profession_of_guardian") }}</label
                    >

                    <InputText
                        id="profession_of_guardian"
                        v-model="form.profession_of_guardian"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.profession_of_guardian"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/4 px-3">
                    <label
                        for="is_parent_or_guardian_owning_house"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_parent_or_guardian_owning_house") }}</label
                    >

                    <Dropdown
                        v-model="form.is_parent_or_guardian_owning_house"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="
                            form.errors.is_parent_or_guardian_owning_house
                        "
                    />
                </div>
                <div class="md:w-1/4 px-3">
                    <label
                        for="is_parent_or_guardian_renting_house"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_parent_or_guardian_renting_house") }}</label
                    >

                    <Dropdown
                        v-model="form.is_parent_or_guardian_renting_house"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="
                            form.errors.is_parent_or_guardian_renting_house
                        "
                    />
                </div>
                <div class="md:w-1/4 px-3">
                    <label
                        for="is_parent_or_guardian_business_owner"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_parent_or_guardian_business_owner") }}</label
                    >

                    <Dropdown
                        v-model="form.is_parent_or_guardian_business_owner"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="
                            form.errors.is_parent_or_guardian_business_owner
                        "
                    />
                </div>
                <div class="md:w-1/4 px-3">
                    <label
                        for="is_parent_or_guardian_car_owner"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_parent_or_guardian_car_owner") }}</label
                    >

                    <Dropdown
                        v-model="form.is_parent_or_guardian_car_owner"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_parent_or_guardian_car_owner"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="name_of_benefactor"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("name_of_benefactor") }}</label
                    >

                    <InputText
                        id="name_of_benefactor"
                        v-model="form.name_of_benefactor"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.name_of_benefactor"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="name_of_travel_sponsor"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("name_of_travel_sponsor") }}</label
                    >

                    <InputText
                        id="name_of_travel_sponsor"
                        v-model="form.name_of_travel_sponsor"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.name_of_travel_sponsor"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label
                        for="educational_certificate"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("educational_certificate") }}</label
                    >

                    <Fileinput
                        multiple
                        name="multipule"
                        @file-upload="onFileUpload"
                    />

                    <!-- <FileUpload
                        mode="basic"
                        name="demo[]"
                        :custom-upload="true"
                        @uploader="onFileUpload"
                        accept="application/pdf"
                        :maxFileSize="5000000"
                    >
                    </FileUpload> -->

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.educational_certificate"
                    />
                </div>
            </div>
        </div>
        <div class="card flex justify-end flex-column md:flex-row gap-3 mt-4">
            <div class="flex-1 mb-1">
                <Button
                    label="Next"
                    size="small"
                    severity="success"
                    outlined
                    @click="nextPage()"
                />
            </div>
        </div>
    </section>
</template>
