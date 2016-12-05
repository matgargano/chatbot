window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.Vue = require('vue');
require('bootstrap-sass');
require('vue-resource');
VueCookie = require('vue-cookie');
Vue.use(VueCookie);

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
    next();
});
