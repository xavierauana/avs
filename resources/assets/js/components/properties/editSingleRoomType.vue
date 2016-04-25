<style></style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-2 nav-list">
                <h5 class="nav-list-title">Property </h5>
                <ul class="list-unstyled">
                    <nav-list view="EditBasic" :current-view="currentView">Basic</nav-list>
                    <nav-list view="EditDescription" :current-view="currentView">Description</nav-list>
                    <nav-list view="EditLocation" :current-view="currentView">Location</nav-list>
                    <nav-list view="EditAmenities" :current-view="currentView">Amenities</nav-list>
                    <nav-list view="EditPhotos" :current-view="currentView">Photos</nav-list>
                    <nav-list view="EditPricing" :current-view="currentView">Pricing</nav-list>
                </ul>
            </div>
            <div class="col-sm-10">
                <components :is="currentView"
                            :property.sync="property"
                            transition="fade"
                            transition-mode="out-in"
                            keep-alive>
                </components>
            </div>
        </div>
    </div>

</template>

<script>
    import NavList from "./navList.vue"
    import EditBasic from "./editBasic.vue"
    import EditDescription from "./editDescription.vue"
    import EditLocation from "./editLocation.vue"
    import EditAmenities from "./editAmenities.vue"
    import EditPhotos from "./editPhotos.vue"
    import EditRoomTypes from "./editRoomTypes.vue"
    import EditPricing from "./editPricing.vue"
    export default{
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
        props:{
          property:{
              type:Object,
              default:function(){
                  return {}
              }
          }
        },
        data: function () {
            return {
                currentView: "EditBasic",
                user:this.$root.$data.user,
                auth:this.$root.$data.auth
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
        events: {
            'changeView': function (view) {
                console.log('will change view');
                this.$set('currentView', view);
            },
            'updateProperty': function () {
                var url = '/api/properties/updateProperty';
                this.$http.put(url, this.property).then(function (response) {
                    console.log(response.data)
                });
            }
        },
        components: {
            NavList,
            EditBasic,
            EditDescription,
            EditLocation,
            EditAmenities,
            EditPhotos,
            EditRoomTypes,
            EditPricing,
        }
    }
</script>