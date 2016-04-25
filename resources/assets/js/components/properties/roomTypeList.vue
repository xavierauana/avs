<style></style>
<template>
    <div class="well">
        <div v-for="roomType in property.room_types">
            <h4>{{roomType.name}}</h4>
        </div>

        <button class="btn btn-default" v-show="createNewRoomTypeButton" @click.prevent="createNewRoomType"> Create New Room Type</button>
    </div>
</template>

<script>
    export default{
        props: {
            property: Object
        },
        computed:{
            createNewRoomTypeButton: function(){
                return this.property.property_type.is_multiple ||  this.property.room_types.length == 0
            }
        },
        methods:{
            createNewRoomType: function(){
                this.$dispatch('createNewRoomType')
            }
        }
    }
</script>