import './bootstrap';
import { createApp } from 'vue';
// import IncrementCounter from './components/IncrementCounter.vue';
import ExampleComponent from './components/ExampleComponent.vue';

createApp({})
    .component('ExampleComponent', ExampleComponent)
    .mount('#app')
