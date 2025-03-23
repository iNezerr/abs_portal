<script setup>
import Sidebar from "@/Components/Layouts/Sidebar.vue";
import Navbar from "@/Components/Layouts/Navbar.vue";
import Footer from "@/Components/Layouts/Footer.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Notification from "../Components/Notification.vue";

defineProps({
    title: String,
});
</script>

<template>
    <Head :title="title" />
    <Toast />
    <div id="root">
        <slot />
    </div>
</template>
