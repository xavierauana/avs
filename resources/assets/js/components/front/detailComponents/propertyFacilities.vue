<style></style>
<template>
    <div class="facilities">
        <div class="col-xs-2">
            Facilities
        </div>
        <div class="col-xs-10">
            <div class="col-xs-6" v-for="item in facilities">
                <li>{{item.label}}</li>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            facilities:{
                type: Array
            }
        }
    }
</script>