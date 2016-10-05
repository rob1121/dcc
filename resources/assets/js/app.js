require('./bootstrap');
window.laroute = require('./laroute');
import * as vFilter from "./mixins/filters";

Vue.component('dcc-input', require('./components/Input.vue'));
Vue.component('dcc-textarea', require('./components/Textarea.vue'));
Vue.component('dcc-button', require('./components/Button.vue'));
Vue.component('dcc-datepicker', require('./components/Datepicker.vue'));
Vue.component('dcc-modal', require('./components/Modal.vue'));
Vue.component('dcc-pulse', require('./components/PulseLoader.vue'));

Vue.filter('trim', vFilter.trim);
Vue.filter('count', vFilter.count);
Vue.filter('latestRevision', vFilter.latestRevision);
Vue.filter('telfordStandardDate', vFilter.telfordStandardDate);
Vue.filter('internalRoute', vFilter.internalRoute);
Vue.filter('externalRoute', vFilter.externalRoute);
Vue.filter('isNewRevision', vFilter.isNewRevision);
