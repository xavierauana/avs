<style>
    div.createSingleRoomType{
        background-color: white;
    }
    div.createSingleRoomType h1{
        margin-top: 0;
    }

</style>
<template>
        <div class="container">
            <h1 class="text-center">List Your Space</h1>

            <p class="text-center">We lets you make money renting out your place.</p>

            <div class="well">
                <form class="form" @submit.prevent="submit">
                    <div class="form-group">
                        <label for="property_type_id">Property Type</label>
                        <select name="property[property_type_id]" id="property_type_id" v-model="selectedPropertyType" class="form-control" required>
                            <option :value="{}" selected> Selected a property type </option>
                            <option v-for="type in propertyTypes" :value="type.id">
                                {{type.label}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_type_list_id">Room Type</label>
                        <select name="roomType[room_type_list_id]" id="room_type_list_id" class="form-control" v-model="selectedRoomType">
                            <option :value="{}" selected> Selected a room type </option>
                            <option v-for="type in roomTypes" :value="type.id" :selected="$index==0">{{type.label}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="occupancy">Occupancy</label>
                        <select name="roomType[occupancy]" id="occupancy" class="form-control" v-model="occupancy">
                            <option value="0"> How much people you room can fill? </option>
                            <option v-for="number in 10" :value="number+1">{{number+1}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-control" v-model="city" disabled>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Create" class="btn btn-default">
                    </div>
                </form>
            </div>
        </div>

</template>

<script>
    export default{
        created:function(){
            this.$http.get('/api/properties/newSingle').then(function (response) {
                this.$set('propertyTypes', response.data.propertyTypes);
                this.$set('roomTypes', response.data.roomTypeLists);
            })
        },
        http: {
            headers: {
                'X-CSRF-TOKEN': document.getElementById("csrf-token").getAttribute('content')
            }
        },
        data: function () {
            return {
                propertyTypes: [],
                roomTypes: [],
                selectedPropertyType:{},
                selectedRoomType:{},
                occupancy:0,
                city:"Hong Kong"
            }
        },
        methods: {
            submit: function (e) {
                var data = new FormData(e.target);
                if(typeof  this.selectedPropertyType != 'undefined'){
                    this.$http.post('/api/properties/createNew', data).then(function (response) {
                        console.log(response);
                        if (response.data.status == 'completed'){
                            this.$router.go({ name: 'editRoomTypes', params: { property_id: response.data.property_id }})
                        }
                    })
                }else{
                    alert("You haven't selected the property type!")
                }

            }
        }
    }
</script>