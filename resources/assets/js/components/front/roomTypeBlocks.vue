<style></style>
<template>
    <div class="roomTypes">
        <div class="row" v-for="roomType in property.room_types | occupancyFilter "
             style="margin-bottom:15px;margin-top:15px;">
            <div class="col-xs-2">
                <img :src="getRoomTypeFirstImage(roomType)" style="max-height:100px" class="img-responsive">
            </div>
            <div class="col-xs-8">
                <h4>{{roomType.type.label}}</h4>

                <div
                        v-html="roomType.descriptionHtml"
                        :class="{'coverDescription':isTooMuch(roomType.descriptionHtml)}"></div>
            </div>
            <div class="col-xs-2">
                <button class="btn-default btn" @click.prevent="chooseRoomType(roomType)">Select
                </button>
            </div>
        </div>
    </div>


</template>

<script>
    export default{
        props: {
            property: {
                type: Object
            }
        },
        filters: {
            occupancyFilter: function (rooms) {
                if (this.isValid(rooms)) {
                    return rooms.filter(function (room) {
                        return room.occupancy >= this.$route.query.occupancy
                    }.bind(this));
                }
            }
        },
        methods: {
            getRoomTypeFirstImage: function (roomType) {
                if (roomType.media.length > 0) {
                    return roomType.media[0].link
                }
            },
            chooseRoomType: function (roomType) {
                console.log('fire event');
                this.$dispatch('change-room-type', roomType);
            },
            isTooMuch:function (description) {
                if (this.propertyIsLoaded()) {
                    var numOfRow = (description.match(/<br\/>|<br \/>/g) || []).length;
                    if(numOfRow > 3 || description.length > 100){
                        return true;
                    }
                    return false
                }
                return false
            }
        }
    }
</script>