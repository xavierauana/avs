/**
 * Created by Xavier on 13/1/16.
 */

require('moment');

var Vue = require('vue');

Vue.use(require('vue-resource'));

Vue.config.debug = true;

import FrontEndFooter from './components/frontEndFooter.vue'
import PageNotFound from './components/pageNotFound.vue'
Vue.component("FrontEndFooter", FrontEndFooter);
Vue.component("PageNotFound", PageNotFound);

import Index from "./components/properties/editPage.vue"

new Vue({
    el:"body",
    data:{
        currentView:"Index",
    },
    components:{
        Index
    },
    ready: function () {
    }
});