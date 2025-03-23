<script setup>
import { markRaw, ref, computed, provide, onMounted } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { loadLanguageAsync } from "laravel-vue-i18n";
import StepIndicatorItem from "@/components/Stepper/StepIndicatorItem.vue";

import PersonalInfoForm from "./Forms/PersonalInfoForm.vue";
import ChurchInfoForm from "./Forms/ChurchInfoForm.vue";
import HealthInfoForm from "./Forms/HealthInfoForm.vue";
import CrimininalInfoForm from "./Forms/CrimininalInfoForm.vue";
import RecommendationInfoForm from "./Forms/RecommendationInfoForm.vue";
import SocialHistoryForm from "./Forms/SocialHistoryForm.vue";
import Confirm from "./Forms/Confirm.vue";
import { useForm } from "@inertiajs/vue3";

const locales = ref([
    {
        label: "English",
        lang: "gb",
    },

    {
        label: "French",
        lang: "fr",
    },
]);
const selectedLocale = ref();

const items = ref([
    markRaw({ label: "Personal Info", component: PersonalInfoForm }),
    markRaw({ label: "Church Info", component: ChurchInfoForm }),
    markRaw({ label: "Health Info", component: HealthInfoForm }),
    markRaw({ label: "Criminal Info", component: CrimininalInfoForm }),
    markRaw({
        label: "Recommendation Info",
        component: RecommendationInfoForm,
    }),
    markRaw({ label: "Social History", component: SocialHistoryForm }),
    markRaw({ label: "Confirm", component: Confirm }),
]);

const form = useForm({});
const currentStepIndex = ref(0);

const currentStepComponent = computed(
    () => items.value[currentStepIndex.value]
);

const setLocale = (newLocale) => {
    let { value } = newLocale;
    if (value == undefined) {
        value = newLocale;
    }

    selectedLocale.value = value;

    localStorage.setItem("locale", value);

    loadLanguageAsync(value == "gb" ? "en" : value);
};

const formData = ref({});
provide("formData", formData);

const handleNextPage = (event) => {
    formData.value = { ...formData.value, ...event.formData };
    console.log(formData.value);
    currentStepIndex.value = event.pageIndex + 1;
};

const handlePrevPage = (event) => {
    currentStepIndex.value = event.pageIndex - 1;
};

onMounted(() => {
    const locale = localStorage.getItem("locale") || "en";
    setLocale(locale);
});

// const handleFormSubmitted = (submittedData) => {
//     // Validate and collect form data from the current step
//     formData.value = { ...formData.value, ...submittedData };

//     alert(formData)
// };
</script>

<template>
    <div>
        <GuestLayout title="Apply">
            <div class="w-24 flex justify-content-end">
                <Dropdown
                    v-model="selectedLocale"
                    :options="locales"
                    optionLabel="label"
                    optionValue="lang"
                    class="w-full md:w-14rem"
                    @change="setLocale"
                >
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex">
                            <span :class="[`fi fi-${slotProps.value}`]"></span>
                        </div>
                    </template>
                    <template #option="slotProps">
                        <span
                            :class="[`fi fi-${slotProps.option.lang}`]"
                        ></span>
                        <!-- <div class="flex align-items-center">
                            <div>{{ slotProps.option.label }}</div>
                        </div> -->
                    </template>
                </Dropdown>
            </div>

            <section
                class="min-h-screen flex flex-col max-w-7xl mx-auto shadow-md rounded-md px-4"
            >
                <div class="mx-4 p-4">
                    <div class="flex items-center">
                        <StepIndicatorItem
                            v-for="(step, index) in items"
                            :key="index"
                            :label="step.label"
                            :isActive="currentStepIndex >= index"
                            :length="items.length"
                            :step="index"
                        />
                    </div>
                </div>

                <section id="content" class="overscroll-y-auto">
                    <component
                        :is="currentStepComponent.component"
                        v-if="currentStepComponent"
                        @next-page="handleNextPage"
                        @prev-page="handlePrevPage"
                    />
                </section>
            </section>
        </GuestLayout>
    </div>
</template>

<style scoped>
.p-dropdown-trigger {
    display: none !important;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
</style>
