/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */
const app = createApp({});

import AssetsStats from './components/AssetsStats.vue';
import Dashboard from './components/Dashboard.vue';
import Statistics from './components/Statistics.vue';
import SurveyorDashboard from './components/SurveyorDashboard.vue';
import Controls from './components/controls/Controls.vue';
import Trial from './components/Asset/Trial.vue';
import Create from './components/Asset/Create.vue';
import Edit from './components/Asset/Edit.vue';
import SurveyEdit from './components/Survey/SurveyEdit.vue';
import SurveyImages from './components/Survey/SurveyImages.vue';
import SurveyGeneral from './components/Survey/SurveyGeneral.vue';
import AssetEdit from './components/Survey/AssetEdit.vue';
import AssetDetails from './components/Survey/AssetDetails.vue';
import Users from './components/User/Users.vue';
import UserCreate from './components/User/UserCreate.vue';
import UserEdit from './components/User/UserEdit.vue';

// import "vue-easytable/libs/theme-default/index.css";
// import VueEasytable from "vue-easytable";
// Vue.use(VueEasytable);

app.component('assets-stats', AssetsStats);
app.component('controls', Controls);
app.component('dashboard', Dashboard);
app.component('statistics', Statistics);
app.component('surveyor-dashboard', SurveyorDashboard);
app.component('trial', Trial);
app.component('create-asset', Create);
app.component('edit-asset', Edit);
app.component('edit-survey', SurveyEdit);
app.component('survey-images', SurveyImages);
app.component('survey-general', SurveyGeneral);
app.component('survey-editinfo', AssetEdit);
app.component('asset-details', AssetDetails);
app.component('users', Users);
app.component('user-create', UserCreate);
app.component('user-edit', UserEdit);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
