import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import './axios'
import PrimeVue from 'primevue/config';
// import 'primevue/resources/themes/aura-light-green/theme.css'
import 'primevue/resources/themes/lara-light-green/theme.css';
import 'primeicons/primeicons.css'
import 'primevue/resources/primevue.min.css';

const pinia = createPinia();
const app = createApp(App)
app.use(pinia)
app.use(router)
app.use(PrimeVue);

app.mount('#app')   
