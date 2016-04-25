<style></style>
<template>
    <div>
        <h1>Room Types</h1>
        <button class="btn btn-success btn-block" @click.prevent="createNew">Add New Room Type</button>
        <br>
        <div class="panel panel-default" v-show="property.room_types.length>0">
            <div class="panel-heading">
                <h2 class="panel-title">Existing Rooms</h2>
            </div>
            <table class="table">
                <thead>
                <th>Room Type</th>
                <th>Inventory</th>
                <th></th>
                </thead>
                <tbody>
                    <tr v-for="type in property.room_types">
                        <td>{{type.type.label}}</td>
                        <td>{{type.availability}}</td>
                        <td>
                            <a href="" class="btn btn-info" v-link="{name:'editRoomType', params:{roomType_id: type.id}}">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</template>

<script>
    export default{
        props:{
            property:{
                type:Object,
                default:function(){
                    return{}
                }
            }
        },
        methods:{
            createNew: function () {
                this.$router.go({
                    name:'createRoomType',
                    params:{
                        property_id: this.$route.params.property_id
                    }
                });
            }
        }
    }
</script>