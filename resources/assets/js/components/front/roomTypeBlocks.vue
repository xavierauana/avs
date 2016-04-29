<style>
    div.roomTypeDescription{
        max-height: 150px;
        overflow: hidden;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#1e5799+0,ffffff+100&0+0,1+100 */
        background: -moz-linear-gradient(top,  rgba(30,87,153,0) 0%, rgba(255,255,255,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(30,87,153,0) 0%,rgba(255,255,255,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(30,87,153,0) 0%,rgba(255,255,255,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#001e5799', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
    }
</style>
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
                        class="roomTypeDescription"
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
            isTooMuch: function (description) {
                var numOfRow = (description.match(/<br\/>|<br \/>/g) || []).length;
                if (numOfRow > 3 || description.length > 100) {
                    return true;
                }
                return false
            }
        }
    }
</script>