<style>
    .fade-transition {
        transition: opacity .2s ease;
    }

    .fade-enter, .fade-leave {
        opacity: 0;
    }

    li.active {
        background-color: #e1e1e1;
        font-weight: 600;
    }

    h5.nav-list-title {
        color: grey;
        font-size: 0.9em;
        font-weight: 600;
    }

    .nav-list li {
        cursor: pointer;
        font-size: 1.1em;
        margin-bottom: 10px;
        padding-left: 10px;
    }

    .container > .row {
        margin-bottom: 15px;
    }

    fieldset {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #dfdfdf;
    }

    fieldset legend {
        border: none;
    }
</style>

<template>
    <div class="container-fluid">
        <page-header :user="user" :auth="auth"></page-header>
        <component :is="currentView" :property="property"></component>
    </div>
</template>

<script>
    import EditSingleRoomType from "./editSingleRoomType.vue"
    import EditMultipleRoomType from "./editMultipleRoomType.vue"
    import PageHeader from "./pageHeader.vue"
    export default{
        route: {
            data: function (transition) {
                var propertyId = this.$route.params.property_id;
                this.$http.get('/api/getTheProperty/' + propertyId).then(function (response) {
                    response.data.property.amenities = response.data.property.amenities.reduce(function(previous, amenity){
                        previous.push(amenity.id);
                        return previous;
                    },[]);

                    var data = {
                        property: response.data.property
                    }

                    if(response.data.property.property_type.is_multiple){
                        data['currentView'] = "EditMultipleRoomType"
                    }else{
                        data['currentView'] = "EditSingleRoomType"
                    }

                    transition.next(data)
                });
            }
        },
        http: {
            headers: {
                "X-CSRF-TOKEN": document.getElementById("csrf-token").getAttribute('content')
            }
        },
        ready:function(){
            if(!this.auth){
                this.$http.get('/api/isAuth').then(function(response){
                    if(response.data.auth){
                        this.$set('user',response.data.user )
                    }else{
                        window.location = "/"
                    }
                })
            }
        },
        data: function () {
            return {
                currentView: "",
                property: {},
                user:this.$root.$data.user
            }
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
        methods: {
            isCurrentView: function (view) {
                return view == this.currentView ? "active" : "";
            },
            changeView: function (view) {
                this.$emit('changeView', view);
            }
        },
        components: {
            PageHeader,
            EditSingleRoomType,
            EditMultipleRoomType
        }
    }
</script>