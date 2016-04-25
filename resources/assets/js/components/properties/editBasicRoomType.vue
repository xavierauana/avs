<style></style>
<template>
    <div>
        <form action="" @submit.prevent="updateRoomTypeBasic">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="occupancy">Occupancy</label>
                        <select class="form-control" name="occupancy" id="occupancy" v-model="occupancy">
                            <option value="0">--Select How Many people you room can fit --</option>
                            <option v-for="index in 10" :value="index+1">{{ index+1 }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="beds">Beds</label>
                        <select class="form-control" name="occupancy" id="beds" v-model="beds">
                            <option value="0">--Select How Beds you have --</option>
                            <option v-for="index in 10" :value="index+1">{{ index+1 }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="bathrooms">Bathroom</label>
                        <select class=form-control name="occupancy" id="bathrooms" v-model="bathrooms">
                            <option value="0">--Select How Bathroom you have --</option>
                            <option v-for="index in 10" :value="index+1">{{ index+1 }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="submit" value="Submit">
        </form>
    </div>
</template>

<script>
    export default{
        props:{
            roomType: Object
        },
        data:function(){
            return {
                occupancy:0,
                beds:0,
                bathrooms:0
            }
        }
    }
</script>