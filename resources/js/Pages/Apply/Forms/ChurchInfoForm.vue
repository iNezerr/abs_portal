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
    is_born_again: formData?.is_born_again || "",
    is_called: formData?.is_called || "",
    explain_calling: formData?.explain_calling || "",
    church: formData?.church || "",
    role_in_church: formData?.role_in_church || "",
    duration_of_service: formData?.duration_of_service || 0,
    history_before_born_again: formData?.history_before_born_again || "",
    history_of_present_church: formData?.history_of_present_church || "",
    history_of_roles_in_church: formData?.history_of_roles_in_church || "",
    reason_for_coming_to_bible_school:
        formData?.reason_for_coming_to_bible_school || "",
});

const emit = defineEmits(["next-page", "prev-page"]);

const nextPage = () => {
    const pageIndex = 1;
    form.post(route("apply.store-church-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.is_born_again = form.is_born_again;
            formData.is_called = form.is_called;
            formData.explain_calling = form.explain_calling;
            formData.church = form.church;
            formData.role_in_church = form.role_in_church;
            formData.duration_of_service = form.duration_of_service;
            formData.history_before_born_again = form.history_before_born_again;
            formData.history_of_present_church = form.history_of_present_church;
            formData.history_of_roles_in_church =
                form.history_of_roles_in_church;
            formData.reason_for_coming_to_bible_school =
                form.reason_for_coming_to_bible_school;

            emit("next-page", { formData, pageIndex });
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 1 });
};

onMounted(async () => {
    try {
        const response = await fetch(
            route("session.get", { key: "church_info" })
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
                        for="is_born_again"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_born_again") }}</label
                    >

                    <Dropdown
                        v-model="form.is_born_again"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_born_again"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="history_before_born_again"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("history_before_born_again") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="history_before_born_again"
                        v-model="form.history_before_born_again"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.history_before_born_again"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="church"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("church") }}</label
                    >

                    <InputText
                        id="church"
                        v-model="form.church"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.church"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="history_of_present_church"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("history_of_present_church") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="history_of_present_church"
                        v-model="form.history_of_present_church"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.history_of_present_church"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="duration_of_service"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("duration_of_service") }}</label
                    >

                    <InputNumber
                        id="duration_of_service"
                        v-model="form.duration_of_service"
                        class="w-full"
                        inputId="integeronly"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.duration_of_service"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="role_in_church"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("role_in_church") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="role_in_church"
                        v-model="form.role_in_church"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.role_in_church"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label
                        for="history_of_roles_in_church"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("history_of_roles_in_church") }}</label
                    >

                    <Textarea
                        id="history_of_roles_in_church"
                        v-model="form.history_of_roles_in_church"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.history_of_roles_in_church"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_called"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("is_called") }}</label
                    >

                    <Dropdown
                        v-model="form.is_called"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="$t('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_called"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="explain_calling"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("explain_calling") }}</label
                    >

                    <InputText
                        id="explain_calling"
                        v-model="form.explain_calling"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.explain_calling"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label
                        for="reason_for_coming_to_bible_school"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("reason_for_coming_to_bible_school") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="reason_for_coming_to_bible_school"
                        v-model="form.reason_for_coming_to_bible_school"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.reason_for_coming_to_bible_school"
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
