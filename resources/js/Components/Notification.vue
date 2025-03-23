<script setup>
    import { onMounted, ref } from "vue";

    const props = defineProps({
        message: {
            type: String,
        },
        status: {
            type: String,
        },
        duration: {
            type: Number,
        },
    });

    const showNotification = ref(false);

    const emit = defineEmits(["closeAlert"]);

    onMounted(() => {
        showNotification.value = true;
        setTimeout(() => (showNotification.value = false), props.duration);
    });
</script>

<template>
    <div v-if="props.message && showNotification" class="flex items-center justify-center">
        <div class="bg-white border border-slate-300 w-max h-20 shadow-lg rounded-md gap-4 p-4 flex flex-row items-center justify-center">
            <section class="w-6 h-full flex flex-col items-center justify-start">
                <svg width="100%" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 13.25C10.9518 13.25 13.75 10.4518 13.75 7C13.75 3.54822 10.9518 0.75 7.5 0.75C4.04822 0.75 1.25 3.54822 1.25 7C1.25 10.4518 4.04822 13.25 7.5 13.25Z" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4.3269 7.96143C4.80767 9.69219 6.73075 10.7499 8.46152 10.2691C9.51921 9.8845 10.3846 9.01912 10.6731 7.96143" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.0481 5.55767C9.91536 5.55767 9.80774 5.45005 9.80774 5.31729C9.80774 5.18453 9.91536 5.0769 10.0481 5.0769" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.0481 5.5577C10.1809 5.5577 10.2885 5.45008 10.2885 5.31732C10.2885 5.18456 10.1809 5.07693 10.0481 5.07693" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4.95193 5.55767C4.81917 5.55767 4.71155 5.45005 4.71155 5.31729C4.71155 5.18453 4.81917 5.0769 4.95193 5.0769" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4.95197 5.5577C5.08473 5.5577 5.19235 5.45008 5.19235 5.31732C5.19235 5.18456 5.08473 5.07693 4.95197 5.07693" stroke="#21ce8f" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </section>
            <section class="h-full flex flex-col items-start justify-end gap-1">
                <h1 class="text-base font-semibold text-zinc-800 antialiased">Successfully saved!</h1>
                <p class="text-sm font-medium text-zinc-400 antialiased">Anyone with a link can now view this file</p>
            </section>
            <section class="w-5 h-full flex flex-col items-center justify-start">
                <button type="button" @click="emit('closeAlert')" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-default" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </section>
        </div>
    </div>
</template>
@click="emit('closeAlert')"
