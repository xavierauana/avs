<style></style>
<template>
    <div class="well">
        <fieldset>
            <legend>Room Type</legend>
            <div class="form-group">
                <label for="room_type_list_id">Room Type</label>
                <select name="roomType[][room_type_list_id]" id="room_type_list_id" class="form-control"
                        v-model="selectedRoomType">
                    <option :value="{}" selected> Selected a room type</option>
                    <option v-for="type in roomTypes" :value="type.id" :selected="$index==0">{{type.label}}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="occupancy">Occupancy</label>
                <select name="roomType[][occupancy]" id="occupancy" class="form-control" v-model="occupancy">
                    <option value="0"> How much people you room can fill?</option>
                    <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                </select>
            </div>
        </fieldset>
    </div>
</template>

<script>
    export default{
        props:{
            roomTypes:{
                type:Array,
                default:function(){
                    return []
                }
            }
        },
        data: function () {
            return {
                selectedRoomType: {},
                occupancy: 0,
            }
        }
    }
</script>