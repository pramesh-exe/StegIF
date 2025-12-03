import { createApp } from "vue";

import App from "./App.vue";
import router from "./plugins/router.js";
import vuetify from "./plugins/vuetify.js";

import axios from 'axios'
import VueAxios from 'vue-axios'
import UUID from "vue-uuid";

const app = createApp(App);
app
    .use(router)
    .use(vuetify)
    .use(VueAxios, axios)
    .use(UUID)
    .provide('axios', app.config.globalProperties.axios)
    .mount("#app");


