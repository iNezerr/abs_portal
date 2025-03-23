<script setup>
import { ref, onMounted, inject } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";

const formData = inject("formData");

const yesNO = ref([
    { name: "Yes", value: "Yes" },
    { name: "No", value: "No" },
]);

const form = useForm({
    is_having_medical_condition: formData?.is_having_medical_condition,
    medical_condition: formData?.medical_condition,
    is_on_regular_medication: formData?.is_on_regular_medication,
    medications: formData?.medications,
    has_had_major_surgeries: formData?.has_had_major_surgeries,
    surgeries: formData?.surgeries,
    is_having_allergies: formData?.is_having_allergies,
    allergies: formData?.allergies,
    diseases_treated: formData?.diseases_treated,
});

const emit = defineEmits(["next-page", "prev-page"]);

const nextPage = () => {
    const pageIndex = 2;
    form.post(route("apply.store-health-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.is_having_medical_condition =
                form.is_having_medical_condition;
            formData.medical_condition = form.medical_condition;
            formData.is_on_regular_medication = form.is_on_regular_medication;
            formData.medications = form.medications;
            formData.has_had_major_surgeries = form.has_had_major_surgeries;
            formData.surgeries = form.surgeries;
            formData.is_having_allergies = form.is_having_allergies;
            formData.allergies = form.allergies;
            formData.diseases_treated = form.diseases_treated;

            emit("next-page", { formData, pageIndex });
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 2 });
};

onMounted(async () => {
    try {
        const response = await fetch(
            route("session.get", { key: "health_info" })
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
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_having_medical_condition"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_having_medical_condition") }}</label
                    >

                    <Dropdown
                        v-model="form.is_having_medical_condition"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_having_medical_condition"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="medical_condition"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("medical_condition") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="medical_condition"
                        v-model="form.medical_condition"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.medical_condition"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_on_regular_medication"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_on_regular_medication") }}</label
                    >

                    <Dropdown
                        v-model="form.is_on_regular_medication"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_on_regular_medication"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="medications"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("medications") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="medications"
                        v-model="form.medications"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.medications"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="has_had_major_surgeries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("has_had_major_surgeries") }}</label
                    >

                    <Dropdown
                        v-model="form.has_had_major_surgeries"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="name"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.has_had_major_surgeries"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="surgeries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("surgeries") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="surgeries"
                        v-model="form.surgeries"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.surgeries"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_having_allergies"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_having_allergies") }}</label
                    >

                    <Dropdown
                        v-model="form.is_having_allergies"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_having_allergies"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="allergies"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("allergies") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="allergies"
                        v-model="form.allergies"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.allergies"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label
                        for="diseases_treated"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("diseases_treated") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="diseases_treated"
                        v-model="form.diseases_treated"
                        class="w-full"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.diseases_treated"
                    />
                </div>
            </div>

            <div
                class="card flex justify-end items-end flex-column md:flex-row gap-3 mt-4"
            >
                <div class="flex-1 mb-1 space-x-4">
                    <Button
                        label="Prev"
                        size="small"
                        severity="danger"
                        outlined
                        @click="prevPage()"
                    />
                    <Button
                        label="Next"
                        size="small"
                        severity="success"
                        outlined
                        @click="nextPage()"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
