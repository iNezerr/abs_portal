<script setup>
import { ref, onMounted, inject } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";
import { useDropzone } from "vue3-dropzone";
import Fileinput from "@/Components/FileInput.vue";

const formData = inject("formData");

const recommendedBy = ref([
    { name: "Local Church Pastor", value: "Local Church Pastor" },
    { name: "Bishop", value: "Bishop" },
    { name: "Associate Senior Pastor", value: "Associate Senior Pastor" },
    { name: "General Overseer", value: "General Overseer" },
    { name: "Others", value: "Others" },
]);

const form = useForm({
    recommended_by: formData?.recommended_by,
    recommendation_by_other: formData?.recommendation_by_other,
    recommendation_file: formData?.recommendation_file,
});

const onAdvancedUpload = async (event) => {
    const files = event;

    form.recommendation_file = files[0];
    console.log(form);
};

const emit = defineEmits(["next-page", "prev-page"]);

const nextPage = () => {
    const pageIndex = 4;
    form.post(route("apply.store-recommendation-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.recommended_by = form.recommended_by;
            formData.recommendation_by_other = form.recommendation_by_other;
            formData.recommendation_file = form.recommendation_file;

            emit("next-page", { formData, pageIndex });
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 4 });
};
onMounted(async () => {
    try {
        const response = await fetch(
            route("session.get", { key: "recommendation_info" })
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
                        for="recommended_by"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("recommended_by") }}</label
                    >

                    <Dropdown
                        v-model="form.recommended_by"
                        :options="recommendedBy"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.recommended_by"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="recommendation_by_other"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("recommendation_by_other") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="recommendation_by_other"
                        v-model="form.recommendation_by_other"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.recommendation_by_other"
                    />
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label
                        for="recommendation_file"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("recommendation_file") }}</label
                    >

                    <Fileinput
                        multiple
                        name="multipule"
                        @file-upload="onAdvancedUpload"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.recommendation_file"
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
