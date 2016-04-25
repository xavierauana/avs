<style>
    div.createMultipleRoomType{
        background-color: white;
    }
    div.createMultipleRoomType h1{
        margin-top: 0;
    }

</style>
<template>
    <div class="container">
        <h1 class="text-center">List Your Space</h1>

        <p class="text-center">We lets you make money renting out your place.</p>


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
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" class="form-control" v-model="city" disabled>
                </div>
                <div class="form-group">
                    <input type="submit" value="Create" class="btn btn-default">
                </div>
            </form>
        </div>

</template>

<script>
    import CreateNewRoomTypeForm from './createNewRoomTypeForm.vue'
    export default{
        created:function(){
            this.$http.get('/api/properties/newMultiple').then(function (response) {
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
                city:"Hong Kong",
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
        components: {
            CreateNewRoomTypeForm
        },
        methods: {
            submit: function (e) {
                var data = new FormData(e.target);
                if(typeof  this.selectedPropertyType != 'undefined'){
                    this.$http.post('/api/properties/createNew', data).then(function (response) {
                        console.log(response)
                        if (response.data.status == "completed"){
                            this.$router.go({
                                name: 'createRoomType',
                                params: {
                                    property_id: response.data.property_id
                                }
                            })
                        }
                    })
                }else{
                    alert("You haven't selected the property type!")
                }

            }
        }
    }
</script>