import "./bootstrap";

// import "primeflex/primeflex.css";
import "primevue/resources/themes/lara-light-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import "primeicons/primeicons.css";

import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";

import Avatar from "primevue/avatar";
import AvatarGroup from "primevue/avatargroup";
import Badge from "primevue/badge";
import BadgeDirective from "primevue/badgedirective";
import Button from "primevue/button";
import Card from "primevue/card";
import Checkbox from "primevue/checkbox";
import Column from "primevue/column";
import Calendar from "primevue/calendar";
import ColumnGroup from "primevue/columngroup";
import ConfirmDialog from "primevue/confirmdialog";
import ConfirmPopup from "primevue/confirmpopup";
import ConfirmationService from "primevue/confirmationservice";
import DataTable from "primevue/datatable";
import Dialog from "primevue/dialog";
import DialogService from "primevue/dialogservice";
import Dropdown from "primevue/dropdown";
import DynamicDialog from "primevue/dynamicdialog";
import FileUpload from "primevue/fileupload";
import Image from "primevue/image";
import InputSwitch from "primevue/inputswitch";
import InputText from "primevue/inputtext";
import InputMask from "primevue/inputmask";
import InputNumber from "primevue/inputnumber";
import MultiSelect from "primevue/multiselect";
import Paginator from "primevue/paginator";
import Password from "primevue/password";
import RadioButton from "primevue/radiobutton";
import Ripple from "primevue/ripple";
import Row from "primevue/row";
import SelectButton from "primevue/selectbutton";

import ScrollTop from "primevue/scrolltop";
import Textarea from "primevue/textarea";
import Toast from "primevue/toast";
import Toolbar from "primevue/toolbar";
import Tag from "primevue/tag";
import ToggleButton from "primevue/togglebutton";
import Tooltip from "primevue/tooltip";

import { i18nVue, trans } from "laravel-vue-i18n";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.globEager("./Pages/**/*.vue") // Corrected import function
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(i18nVue, {
            resolve: async (lang) => {
                const langs = await import.meta.glob("../../lang//*.json");
                return await langs[`../../lang/${lang}.json`]();
            },
            onLoad: () => {
                // app.mount(el);
            },
        });

        app
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue, { ripple: true })
            .use(ConfirmationService)
            .use(ToastService)
            .use(DialogService)
            .directive("tooltip", Tooltip)
            .directive("badge", BadgeDirective)
            .directive("ripple", Ripple)
            .component("Avatar", Avatar)
            .component("AvatarGroup", AvatarGroup)
            .component("Badge", Badge)
            .component("Button", Button)
            .component("Card", Card)
            .component("Checkbox", Checkbox)
            .component("ColumnGroup", ColumnGroup)
            .component("Column", Column)
            .component("Calendar", Calendar)
            .component("ConfirmDialog", ConfirmDialog)
            .component("ConfirmPopup", ConfirmPopup)
            .component("DataTable", DataTable)
            .component("Dialog", Dialog)
            .component("Dropdown", Dropdown)
            .component("DynamicDialog", DynamicDialog)
            .component("FileUpload", FileUpload)
            .component("Image", Image)
            .component("InputMask", InputMask)
            .component("InputNumber", InputNumber)
            .component("InputSwitch", InputSwitch)
            .component("InputText", InputText)
            .component("MultiSelect", MultiSelect)
            .component("Paginator", Paginator)
            .component("Password", Password)
            .component("RadioButton", RadioButton)
            .component("Row", Row)
            .component("SelectButton", SelectButton)
            .component("ScrollTop", ScrollTop)
            .component("Tag", Tag)
            .component("Textarea", Textarea)
            .component("Toast", Toast)
            .component("Toolbar", Toolbar)
            .component(
                "ToggleButton",
                ToggleButton
            ).config.globalProperties.__ = trans;
        app.mount(el);
    },
    progress: {
        color: "#4B5",
    },
});
