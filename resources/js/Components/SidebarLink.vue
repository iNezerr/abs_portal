<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() =>
    props.active
        ? "block py-2.5 px-6 rounded bg-primary-500 text-tertiary-700 space-x-4"
        : "block py-2.5 px-6 rounded hover:bg-primary-700 hover:text-tertiary-500 space-x-4"
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
