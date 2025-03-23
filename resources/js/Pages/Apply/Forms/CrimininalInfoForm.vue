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
    is_having_criminal_record: formData?.is_having_criminal_record,
    criminal_records: formData?.criminal_records,
});

const emit = defineEmits(["next-page", "prev-page"]);

const nextPage = () => {
    const pageIndex = 3;
    form.post(route("apply.store-criminal-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.is_having_criminal_record = form.is_having_criminal_record;
            formData.criminal_records = form.criminal_records;

            emit("next-page", { formData, pageIndex });
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 3 });
};
onMounted(async () => {
    try {
        const response = await fetch(
            route("session.get", { key: "criminal_info" })
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
        <!-- component -->
        <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_having_criminal_record"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_having_criminal_record") }}</label
                    >

                    <Dropdown
                        v-model="form.is_having_criminal_record"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        placeholder="{{ __('select_placeholder') }}"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_having_criminal_record"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="criminal_records"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("criminal_records") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="criminal_records"
                        v-model="form.criminal_records"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.criminal_records"
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
