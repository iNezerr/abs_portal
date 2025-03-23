<script setup>
import { ref, onMounted, inject } from "vue";
import { useForm } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";

const formData = inject("formData");

const yesNO = ref([
    { name: "Yes", value: "Yes" },
    { name: "No", value: "No" },
]);

const vices = ref([
    { name: "Fornication", key: "Fornication" },
    { name: "Abortion", key: "Abortion" },
    { name: "Masturbation", key: "Masturbation" },
    { name: "Pornongraphy", key: "Pornongraphy" },
    { name: "Homosexuality", key: "Homosexuality" },
    { name: "Lesbianism", key: "Lesbianism" },
]);

const form = useForm({
    use_narcotics_currently: formData?.use_narcotics_currently,
    current_narcotics_history: formData?.current_narcotics_history,
    use_narcotics_in_past: formData?.use_narcotics_in_past,
    past_narcotics_history: formData?.past_narcotics_history,
    have_been_arrested_before: formData?.have_been_arrested_before,
    arrest_history: formData?.arrest_history,
    have_been_prosecuted_before: formData?.have_been_prosecuted_before,
    prosecution_history: formData?.prosecution_history,
    have_been_jailed_before: formData?.have_been_jailed_before,
    jail_history: formData?.jail_history,
    is_taking_alcohol: formData?.is_taking_alcohol,
    alcohol_history: formData?.alcohol_history,
    use_alcohol_in_past: formData?.use_alcohol_in_past,
    past_alcohol_history: formData?.past_alcohol_history,
    have_been_involved_in_robbery: formData?.have_been_involved_in_robbery,
    past_robbery_history: formData?.past_robbery_history,
    have_been_a_rebel: formData?.have_been_a_rebel,
    past_rebelious_history: formData?.past_rebelious_history,
    have_been_in_prostitution: formData?.have_been_in_prostitution,
    past_prostitution_history: formData?.past_prostitution_history,
    vices: "",
    is_virgin: formData?.is_virgin,
});

const emit = defineEmits(["next-page", "prev-page"]);

const nextPage = () => {
    const pageIndex = 5;
    form.post(route("apply.store-social-info"), {
        preserveScroll: true,
        remember_me: true,
        onSuccess: () => {
            formData.use_narcotics_currently = form.use_narcotics_currently;
            formData.current_narcotics_history = form.current_narcotics_history;
            formData.use_narcotics_in_past = form.use_narcotics_in_past;
            formData.past_narcotics_history = form.past_narcotics_history;
            formData.have_been_arrested_before = form.have_been_arrested_before;
            formData.arrest_history = form.arrest_history;
            formData.have_been_prosecuted_before =
                form.have_been_prosecuted_before;
            formData.prosecution_history = form.prosecution_history;
            formData.have_been_jailed_before = form.have_been_jailed_before;
            formData.jail_history = form.jail_history;
            formData.is_taking_alcohol = form.is_taking_alcohol;
            formData.alcohol_history = form.alcohol_history;
            formData.use_alcohol_in_past = form.use_alcohol_in_past;
            formData.past_alcohol_history = form.past_alcohol_history;
            formData.have_been_involved_in_robbery =
                form.have_been_involved_in_robbery;
            formData.past_robbery_history = form.past_robbery_history;
            formData.have_been_a_rebel = form.have_been_a_rebel;
            formData.past_rebelious_history = form.past_rebelious_history;
            formData.have_been_in_prostitution = form.have_been_in_prostitution;
            formData.past_prostitution_history = form.past_prostitution_history;
            formData.vices = form.vices;
            formData.is_virgin = form.is_virgin;

            emit("next-page", { formData, pageIndex });
        },
    });
};

const prevPage = () => {
    emit("prev-page", { pageIndex: 5 });
};

onMounted(async () => {
    try {
        const response = await fetch(
            route("session.get", { key: "social_info" })
        );
        if (response.ok) {
            const data = await response.json();

            // Set the form fields with the retrieved data
            Object.keys(data).forEach((key) => {
                if (key !== "vices") {
                    form[key] = data[key];
                }
            });

            console.log(form);

            if (form.hasOwnProperty(vices)) {
                delete form[vices];
                console.log("deleted");
            }
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
                        for="use_narcotics_currently"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("use_narcotics_currently") }}</label
                    >

                    <Dropdown
                        v-model="form.use_narcotics_currently"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.use_narcotics_currently"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="current_narcotics_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("current_narcotics_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="current_narcotics_history"
                        v-model="form.current_narcotics_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.current_narcotics_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="use_narcotics_in_past"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("use_narcotics_in_past") }}</label
                    >

                    <Dropdown
                        v-model="form.use_narcotics_in_past"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.use_narcotics_in_past"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="past_narcotics_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("past_narcotics_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="past_narcotics_history"
                        v-model="form.past_narcotics_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.past_narcotics_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_arrested_before"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_arrested_before") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_arrested_before"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_arrested_before"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="arrest_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("arrest_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="arrest_history"
                        v-model="form.arrest_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.arrest_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_prosecuted_before"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_prosecuted_before") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_prosecuted_before"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_prosecuted_before"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="prosecution_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("prosecution_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="prosecution_history"
                        v-model="form.prosecution_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.prosecution_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_jailed_before"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_jailed_before") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_jailed_before"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_jailed_before"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="jail_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("jail_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="jail_history"
                        v-model="form.jail_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.jail_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="is_taking_alcohol"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_taking_alcohol") }}</label
                    >

                    <Dropdown
                        v-model="form.is_taking_alcohol"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_taking_alcohol"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="alcohol_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("alcohol_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="alcohol_history"
                        v-model="form.alcohol_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.alcohol_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="use_alcohol_in_past"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("use_alcohol_in_past") }}</label
                    >

                    <Dropdown
                        v-model="form.use_alcohol_in_past"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.use_alcohol_in_past"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="past_alcohol_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("past_alcohol_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="past_alcohol_history"
                        v-model="form.past_alcohol_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.past_alcohol_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_involved_in_robbery"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_involved_in_robbery") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_involved_in_robbery"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_involved_in_robbery"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="past_robbery_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("past_robbery_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="past_robbery_history"
                        v-model="form.past_robbery_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.past_robbery_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_a_rebel"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_a_rebel") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_a_rebel"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_a_rebel"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="past_rebelious_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("past_rebelious_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="past_rebelious_history"
                        v-model="form.past_rebelious_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.past_rebelious_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="have_been_in_prostitution"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("have_been_in_prostitution") }}</label
                    >

                    <Dropdown
                        v-model="form.have_been_in_prostitution"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.have_been_in_prostitution"
                    />
                </div>

                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        for="past_prostitution_history"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("past_prostitution_history") }}</label
                    >

                    <Textarea
                        rows="3"
                        id="past_prostitution_history"
                        v-model="form.past_prostitution_history"
                        class="w-full"
                    />
                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.past_prostitution_history"
                    />
                </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label
                        for="vices"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("vices") }}</label
                    >

                    <div
                        v-for="vice of vices"
                        :key="vice.key"
                        class="flex align-items-center"
                    >
                        <Checkbox
                            v-model="form.vices"
                            :inputId="vice.key"
                            name="vice"
                            :value="vice.name"
                        />
                        <label :for="vice.key">{{ vice.name }}</label>
                    </div>

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.vices"
                    />
                </div>

                <div class="md:w-1/2 px-3">
                    <label
                        for="is_virgin"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ __("is_virgin") }}</label
                    >

                    <Dropdown
                        v-model="form.is_virgin"
                        :options="yesNO"
                        optionLabel="name"
                        optionValue="value"
                        :placeholder="__('select_placeholder')"
                        class="w-full md:w-14rem"
                    />

                    <InputError
                        class="mt-2 w-full"
                        :message="form.errors.is_virgin"
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
