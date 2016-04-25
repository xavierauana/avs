/**
 * Created by Xavier on 11/1/16.
 */

var VueRouter = require('vue-router');

var Vue = require('vue');

var swal = require('sweetalert');

Vue.use(require('vue-resource'));
Vue.use(VueRouter);

var router = new VueRouter({
    history: true
});

Vue.config.debug = true;

import FrontEndFooter from './components/frontEndFooter.vue'

Vue.component("FrontEndFooter", FrontEndFooter);

Vue.mixin({
    methods: require('./globalMixins/methods.vue')
})

router.map({
    '/': {
        component: require('./components/front/indexPage.vue')
    },
    '/property': {
        component: require('./components/front/list.vue')
    },
    '/property/:property_id': {
        component: require('./components/front/detail.vue')
    },
    '/myreservation': {
        name:'myReservation',
        component: require('./components/front/myReservation.vue')
    },
    '/myreservation/detail/:reservationId': {
        name:'myReservationDetail',
        component: require('./components/front/myReservationDetail.vue')
    },
    '/inbox': {
        name:'myInbox',
        component: require('./components/front/inbox.vue')
    }
}).redirect({
    '*':"/"
});


var Store = require("./Store");
var App = Vue.extend({
    data: function () {
        return {
            api:require('./commons/apiEndPoints')
        }
    },
    events:{
        userChanged: function(data){
            Store.user = data;
            this.$broadcast("topLevelUserUpdated", Store.user);
        },
        authChanged: function(data){
            Store.auth = data;
            this.$broadcast("topLevelAuthUpdated", Store.auth);
        }
    }
});

router.start(App, '#app');
