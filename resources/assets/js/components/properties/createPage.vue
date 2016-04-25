<style>
    .container-fluid.new ul.create-list{
        background-color: white;
    }
</style>
<template>
    <div class="container-fluid new">
        <page-header :user="user" :auth="auth"></page-header>
        <ul v-show="canChoose" class="text-center list-unstyled create-list" >
            <li @click.prevent="selectSingleRoomType">Create Single Room Type Property</li>
            <li @click.prevent="selectMultipleRoomType">Create Multiple Room Type Property</li>
        </ul>
        <component v-show="showComponent" :is="currentView"></component>
    </div>


</template>

<script>
    import PageHeader from "./pageHeader.vue"
    import CreateSingleRoomType from "./createSingleRoomType.vue"
    import CreateMultipleRoomType from "./createMultipleRoomType.vue"
    export default{
        route:{
            data: function(transition){
                this.$http.get('/api/properties/newSingle').then(function (response) {
                    var data = {
                        propertyTypes: response.data.propertyTypes,
                        roomTypes: response.data.roomTypeLists,
                        user: response.data.user,
                        auth: true
                    };
                    if(!response.data.user.canMultiple){
                        this.currentView = "CreateSingleRoomType";
                        this.showComponent = true;
                    }
                    transition.next(data);
                })
            }
        },
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementById("csrf-token").getAttribute('content')
            }
        },
        data: function () {
            return {
                currentView: '',
                selected: false,
                propertyTypes: {},
                roomTypes: {},
                user:this.$root.$data.user,
                auth:this.$root.$data.auth,
                showComponent: false
            }
        },
        computed:{
            canChoose:function(){
                return !this.selected && this.user.canMultiple
            }
        },
        ready:function(){
            if(!this.user.canMultiple) this.$set('currentView', "CreateSingleRoomType");
        },
        watch: {
            user: function (value) {
                console.log('user change from components');
                this.$dispatch('userChanged', value);
            },
            auth: function (value) {
                this.$dispatch('authChanged', value);
            }
        },
        components: {
            PageHeader,
            CreateSingleRoomType,
            CreateMultipleRoomType
        },
        methods: {
            toggleSettings: function(){
                this.selected = !this.selected;
                this.showComponent = !this.showComponent;
            },
            selectSingleRoomType: function () {
                this.toggleSettings();
                this.$set('currentView', 'CreateSingleRoomType');
            },
            selectMultipleRoomType: function () {
                this.toggleSettings();
                this.$set('currentView', 'CreateMultipleRoomType');
            }
        }
    }
</script>