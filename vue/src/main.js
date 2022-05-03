import { createApp } from 'vue'
import App from './App.vue'

import './index.css';

import router from "./router";  // The Vue Router component
import store from "./store";    // The VueX store component
                                // Notifications dependency
import notifications from '@kyvg/vue3-notification'

createApp(App)
    .use(router)
    .use(store)
    .use(notifications)
    .mount('#app')
