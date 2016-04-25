<style></style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-2 nav-list">
                <h5 class="nav-list-title">Property </h5>
                <ul class="list-unstyled">
                    <nav-list view="HotelInformation" :current-view="currentView">Hotel Information</nav-list>
                    <nav-list view="HotelAmenities" :current-view="currentView">Hotel Amenities</nav-list>
                    <nav-list view="EditPhotos" :current-view="currentView">Hotel Photos</nav-list>
                    <nav-list view="RoomTypes" :current-view="currentView">Room Types</nav-list>
                </ul>
            </div>
            <div class="col-sm-10">
                <components :is="currentView"
                            :property.sync="property"
                            transition="fade"
                            transition-mode="out-in">
                </components>
            </div>
        </div>
        <pre>
            {{$data|json}}
        </pre>
    </div>

</template>

<script>
    import NavList from "./navList.vue"
    import HotelInformation from "./hotelInformation.vue"
    import HotelAmenities from "./hotelAmenities.vue"
    import EditPhotos from "./editPhotos.vue"
    import RoomTypes from "./roomTypes.vue"
    export default{
        http:{
          headers:{
              "X-CSRF-TOKEN": document.querySelector('#csrf-token').getAttribute('content')
          }
        },
        props:{
            property:{
                type: Object,
                default:function(){
                    return{}
                }
            }
        },
        data:function(){
            return {
                currentView:"HotelInformation"
            }
        },
        components:{
            NavList,
            HotelInformation,
            HotelAmenities,
            EditPhotos,
            RoomTypes
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
        }
    }
</script>