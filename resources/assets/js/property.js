/**
 * Created by Xavier on 13/1/16.
 */
/**
 * Created by Xavier on 11/1/16.
 */

require('moment');

var VueRouter = require('vue-router');

var Vue = require('vue');

require('sweetalert');

Vue.use(require('vue-resource'));
Vue.use(VueRouter);

Vue.config.debug = true;

var router = new VueRouter({
    history: true
});

import FrontEndFooter from './components/frontEndFooter.vue'
import PageNotFound from './components/pageNotFound.vue'
Vue.component("FrontEndFooter", FrontEndFooter);
Vue.component("PageNotFound", PageNotFound);
Vue.mixin({
    methods: require('./globalMixins/methods.vue')
});


router.map({
    '/properties': {
        name: 'propertiesIndex',
        component: require("./components/properties/indexPage.vue")
    },
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
        component: require("./components/properties/editRoomType.vue")
    }
});


var App = Vue.extend({
    data: function () {
        return {
            user: {},
            auth: false,
            api:require('./commons/apiEndPoints')
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