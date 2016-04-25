<style></style>
<template>
    <div class="col-sm-9">
        <h1>Edit Room </h1>

        <form class="form-horizontal">
            <div class="form-group">
                <label name="room_type_list_id" class="col-sm-2 control-label">Room Type</label>

                <div class="col-sm-10">
                    <select type="text" name="room_type_list_id" class="form-control"
                            v-model="roomType.room_type_list_id">
                        <option :value="0">--Please Select A Room Type--</option>
                        <option v-for="roomType in roomTypes" :value="roomType.id">{{roomType.label}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label name="description" class="col-sm-2 control-label">Description</label>

                <div class="col-sm-10">
                    <textarea class="form-control" name="description" v-model="roomType.description"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Max Occupancy</label>

                <div class="col-sm-10">
                    <select type="text" name="occupancy" class="form-control" v-model="roomType.occupancy">
                        <option :value="0">--Please Select A Number--</option>
                        <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">How Many Inventories</label>

                <div class="col-sm-10">
                    <input type="number" class="form-control" name="availability" min="1"
                           v-model="roomType.availability">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="base_price">Basic Price</label>

                <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">HKD</span>
                        <input type="number" class="form-control" name="base_price" id="base_price"
                               placeholder="Charge per night" aria-describedby="basic-addon1"
                               v-model="roomType.base_price">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="beds">Number of beds</label>

                <div class="col-sm-10">
                    <select type="text" name="beds" id="beds" class="form-control" v-model="roomType.beds">
                        <option :value="0">--Please Select A Number--</option>
                        <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="bathrooms">Number of bathrooms</label>

                <div class="col-sm-10">
                    <select type="text" name="bathrooms" id="bathrooms" class="form-control"
                            v-model="roomType.bathrooms">
                        <option :value="0">--Please Select A Number--</option>
                        <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="bedrooms">Number of bedrooms</label>

                <div class="col-sm-10">
                    <select type="text" name="bedrooms" id="bedrooms" class="form-control"
                            v-model="roomType.bedrooms">
                        <option :value="0">Studio</option>
                        <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                    </select>
                </div>
            </div>
            <!--<button class="btn btn-success">Create</button>-->
            <next-button view="EditRoomAmenities"></next-button>

        </form>
    </div>

</template>

<script>
    import NextButton from './updateButtonRoomType.vue'
    export default{
        props:{
            roomType:{
                type: Object,
                twoWay: true
            },
            roomTypes:{
                type: Array,
                twoWay: true
            }
        },
        components:{
            NextButton
        }
    }
</script>