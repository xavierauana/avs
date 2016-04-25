/**
 * Created by Xavier on 13/1/16.
 */

require('moment');

var VueRouter = require('vue-router');

var Vue = require('vue');

require('sweetalert');

Vue.use(require('vue-resource'));
Vue.use(VueRouter);

var router = new VueRouter({
    history: true
});

Vue.mixin({
    methods: require('./globalMixins/methods.vue')
})

Vue.config.debug = true;

import FrontEndFooter from './components/frontEndFooter.vue'
import PageNotFound from './components/pageNotFound.vue'
Vue.component("FrontEndFooter", FrontEndFooter);
Vue.component("PageNotFound", PageNotFound);

//import Index from "./components/properties/createPage.vue"

router.map({
    '/properties/new':{
        name:'createProperty',
        component: require("./components/properties/createPage.vue")
    },
    '/properties/manage-listing/:property_id': {
        name:'editRoomTypes',
        component: require("./components/properties/editPage.vue")
    },
    '/properties/:property_id/roomTypes/create': {
        name:'createRoomType',
        component: require("./components/properties/createRoomType.vue")
    },
    '/properties/roomTypes/:roomType_id/edit': {
        name:'editRoomType',
        component: require("./components/properties/createRoomType.vue")
    }
});


var App = Vue.extend({
    data: function () {
        return {
            user: {},
            auth: false
        }
    },
    events:{
        userChanged: function(data){
            this.$set('user', data)
        },
        authChanged: function(data){
            this.$set('auth', data)
        }
    }
});

router.start(App, 'body');