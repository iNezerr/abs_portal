<script setup>
import SidebarLink from "@/Components/SidebarLink.vue";

const logout = () => {
    router.post(route("logout"));
};

const props = defineProps({
    isSidebarOpen: {
        type: Boolean,
    },
});

const emit = defineEmits(["toggle-sidebar"]);
</script>

<template>
    <aside
        class="bg-tertiary-900 text-gray-300 flex-col flex-1 flex-shrink-0 lg:flex transition-all duration-200 ease-in-out z-20 h-screen sticky top-0"
        style="width: 290px; min-width: 290px"
        :class="{
            '  hidden': !props.isSidebarOpen,
        }"
    >
        <div class="flex items-baseline justify-between">
            <div
                class="px-6 pt-5 h-16 min-w-full border-b border-b-tertiary-50 shadow-md bg-tertiary-900/50"
                style="width: auto"
            >
                <img
                    src="/images/logo/logo-no-background.png"
                    alt="Ekklesia logo"
                />
            </div>
            <button
                @click="$emit('toggle-sidebar')"
                class="p-2 rounded-md lg:hidden"
            >
                <svg
                    class="w-6 h-6 text-gray-600"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
        <div
            class="sidebar-small-overflow h-full overflow-y-auto scrollbars show"
        >
            <div class="w-full flex flex-row justify-center py-5"></div>

            <!-- Sidebar menu -->
            <ul
                class="sidebar-small-menu w-full float-none flex flex-col font-medium px-1 pb-6 space-y-2"
            >
                <SidebarLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                >
                    <i class="pi pi-chart-bar" style="color: slateblue"></i>

                    <span class="font-medium">Dashboard</span>
                </SidebarLink>

                <li class="relative">
                    <a
                        class="block py-2.5 px-6 rounded hover:bg-slate-700 hover:text-cyan-500"
                        href="documentation.html"
                    >
                        <i class="sidebar-small-icon bx bx-file-find mr-1"></i>
                        <span class="sidebar-small-text">Documentation</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</template>
