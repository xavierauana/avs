<template>
    <div>
        <h1 class="text-center">Help travelers find the right fit</h1>
        <p class="text-center">People searching can filter by listing basics to find a space that matches their needs.</p>
        <hr>
        <form class="form">
            <fieldset>
                <legend>Listing</legend>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="property_type_id">Property Type</label>
                            <select class="form-control" name="propertyType[property_type_id]" id="property_type_id" v-model="property.property_type_id">
                                <option v-for="propertyType in propertyTypes" :value="propertyType.id" >{{propertyType.label}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="property_type_id">Occupancy</label>
                            <select class="form-control" name="roomType[occupancy]" id="" v-model="property.room_types[0].occupancy">
                                <option v-for="number in 10" :value="number+1" >{{number+1}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="property_type_id">Property Type</label>
                            <select class="form-control" name="property[property_type_id]" id="property_type_id" v-model="property.property_type_id">
                                <option v-for="propertyType in propertyTypes" :value="propertyType.id" >{{propertyType.label}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Bathroom</label>
                            <select class="form-control" name="roomType[bathroom]" id="" v-model="property.room_types[0].bathrooms">
                                <option v-for="number in 10" :value="number+1" >{{number+1}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Bedrooms</label>
                            <select class="form-control" name="roomType[bedrooms]" id="" v-model="property.room_types[0].bedrooms">
                                <option v-for="number in 10" :value="number+1" >{{number+1}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Beds</label>
                            <select class="form-control" id="" v-model="property.room_types[0].beds">
                                <option v-for="number in 10" :value="number+1" >{{number+1}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
            <next-button view="EditDescription"></next-button>
        </form>
    </div>
</template>

<script>
    import NextButton from './nextButton.vue';

    export default {
        ready: function(){
            this.$http.get('/api/properties/new').then(function (response) {
                this.$set("propertyTypes", response.data.propertyTypes);
                this.$set("roomTypes", response.data.roomTypeLists);
            }, function (response) {
                console.log(response)
            });
        },
        data: function(){
            return {
                propertyTypes:[],
                roomTypes:[]
            }
        },
        props: {
            property: {
                type: Object,
                twoWay: true
            }
        },
        components:{
            NextButton
        },
        watch:{
            property:function(){
                this.propertyTypeId = this.property.property_type.id;
                this.roomTypeId = this.property.room_types[0].id;
                if(this.isValid(this.property.room_types[0].occupancy)) this.roomTypeId = this.property.room_types[0].occupancy;
            }
        }
    }
</script>