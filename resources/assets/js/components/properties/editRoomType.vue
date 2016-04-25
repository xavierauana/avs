<style></style>
<template>
    <div class="container-fluid new">
        <page-header :user="user" :auth="auth"></page-header>
        <div class="container">
            <div class="col-sm-3">
                <nav>
                    <ul class="nav">
                        <li><a href="testing" @click.prevent="currentView='EditRoomBasicSetting'">Basic Setting</a></li>
                        <li><a href="editRoomAmenities" @click.prevent="currentView='EditRoomAmenities'">Room Amenities</a></li>
                        <li><a href="testing" @click.prevent="currentView='EditRoomTypePhotos'">Room Photos</a></li>
                    </ul>
                </nav>
            </div>
            <component :is="currentView" :room-type.sync="roomType" :room-types.sync="roomTypes"></component>
        </div>
    </div>
</template>

<script>
    import PageHeader from './pageHeader.vue'
    import EditRoomBasicSetting from './editRoomBasicSetting.vue'
    import EditRoomAmenities from './roomAmenities.vue'
    import EditRoomTypePhotos from './editRoomTypePhoto.vue'
    export default{
        route: {
            data: function (transition) {
                var url, data = {};
                url = '/api/properties/multipleRoomType';
                if (this.$route.params.roomType_id) {
                    url += '/' + this.$route.params.roomType_id;
                }
                this.$http.get(url).then(function (response) {
                    if (response.ok) {
                        var roomType = Object.keys(response.data.roomType).length > 0 ? response.data.roomType : {
                            room_type_list_id: 0,
                            occupancy: 0,
                            availability: 1,
                            base_price: "",
                            weekly_price: 0,
                            monthly_price: 0,
                            beds: 0,
                            bedrooms: 0,
                            bathrooms: 0,
                            description: "",
                            property_id: this.$route.params.property_id
                        }
                        data = {
                            user: response.data.user,
                            roomTypes: response.data.roomTypeLists,
                            auth: true,
                            roomType: roomType
                        };
                        transition.next(data)
                    }

                });
            }
        },
        http: {
            headers: {
                "X-CSRF-TOKEN": document.querySelector("#csrf-token").getAttribute('content')
            }
        },
        data: function () {
            return {
                currentView: 'EditRoomBasicSetting',
                auth: false,
                user: this.$root.$data.user,
                roomTypes: [],
                roomType: {}
            }
        },
        events:{
            updateRoomType:function(){
                var data = new FormData();
                for (var key in this.roomType) {
                    data.append(key, this.roomType[key]);
                }
                var url = '/api/properties/updateMultipleRoomType';
                this.$http.post(url, data).then(function (response) {
                    if (response.data.roomType.id) {
                        console.log('roomType updated');
                    }
                })
            },
            changeView: function(view){
                this.$set('currentView', view);
            }
        },
        components: {
            PageHeader,
            EditRoomBasicSetting,
            EditRoomAmenities,
            EditRoomTypePhotos
        }
    }
</script>
