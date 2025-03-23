<script setup>
import { computed } from "vue";

const props = defineProps(["label", "isActive", "length", "step"]);

const showBorder = computed(() => {
    return props.step !== props.length - 1;
});
</script>

<template>
    <div class="flex items-center text-white relative">
        <div
            :class="[
                'rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2',
                isActive ? 'border-teal-600 bg-teal-600' : 'border-gray-300',
            ]"
        ></div>
        <div
            class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-teal-600"
        >
            {{ label }}
        </div>
    </div>
    <div
        :class="[
            'flex-auto border-t-2 transition duration-500 ease-in-out',
            isActive ? 'border-teal-600 bg-teal-600' : 'border-gray-300',
            showBorder ? 'border' : 'border-none',
        ]"
    ></div>
</template>
