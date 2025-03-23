<script setup>
import { ref, onMounted, inject } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";

const formData = inject("formData");
const form = useForm({});
const loading = ref(false);

const emit = defineEmits(["form-submit", "prev-page"]);

const nextPage = () => {
    Object.keys(formData).forEach((key) => {
        form[key] = formData[key];
    });

    console.log(["f", form]);

    loading.value = true;
    form.post(route("apply.store-confirmation"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            loading.value = false;
        },
        onError: (error) => {
            loading.value = false;
            console.log(error);
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 6 });
};
</script>

<template>
    <section class="">
        <!-- component -->
        <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
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
                        type="button"
                        label="Submit"
                        size="small"
                        severity="success"
                        outlined
                        @click="nextPage()"
                        :loading="loading"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
