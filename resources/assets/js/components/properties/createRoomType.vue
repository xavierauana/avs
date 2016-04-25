<style></style>
<template>
    <div class="container-fluid new">
        <page-header :user="user" :auth="auth"></page-header>
        <div class="container">
            <div class="col-sm-12">
                <h1>Create a new room type</h1>

                <form class="form-horizontal" @submit.prevent="submit">
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
                    <button class="btn btn-success">Create</button>

                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import PageHeader from './pageHeader.vue'
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
                auth: false,
                user: this.$root.$data.user,
                roomTypes: [],
                roomType: {}
            }
        },
        methods: {
            submit: function () {
                var data = new FormData();
                for (var key in this.roomType) {
                    data.append(key, this.roomType[key]);
                }
                console.log('form submit');
                console.log(data);
                var url = '/api/properties/updateMultipleRoomType';
                this.$http.post(url, data).then(function (response) {
                    if (response.data.roomType.id) {
                        this.$router.go({
                            name: 'editRoomTypes',
                            params: {
                                property_id: this.$route.params.property_id
                            }
                        })
                    }
                })
            }
        },
        components: {
            PageHeader
        }
    }
</script>
