<script setup>
import { computed, onMounted } from 'vue';


const props = defineProps({
    message: {
        type: String
    },
    type: {
        type: String,
        default: "info",
        required: false,
    },
    duration: {
        type: Number
    },

    autoClose: { type: Boolean, default: true, required: false },
    duration: { type: Number, default: 5, required: false },
})

const emit = defineEmits(['closeAlert'])



// a computed property to set
// the icon for the notification
const alertIcon = computed(() => {
    switch (props.type) {
        case "error":
            return "ri-emotion-unhappy-line";
        case "warning":
            return "ri-error-warning-line";
        case "success":
            return "ri-emotion-happy-line";
        default:
            return "ri-information-line";
    }
});

const alertColor = computed(() => {
    switch (props.type) {
        case "error":
            return "bg-red-100";
        case "warning":
            return "bg-yellow-100";
        case "success":
            return "bg-green-100";
        default:
            return "bg-blue-100";
    }
});

const alertType = computed(() => {
    switch (props.type) {
        case "error":
            return "Error! ";
        case "warning":
            return "Warning! ";
        case "success":
            return "Success! ";
        default:
            return "Something went wrong! ";
    }
});



onMounted(() => {

});

</script>


<template>
    <div :class="alertColor" class="flex p-4 mb-4 text-sm text-green-800 rounded-lg  dark:bg-gray-800 dark:text-green-400"
        role="alert">
        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Info</span>
        <div>
            <span class="font-medium" v-text="alertType"></span> {{ props.message }}
        </div>
        <button type="button" @click="emit('closeAlert')"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            data-dismiss-target="#toast-default" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</template>