<style></style>
<template>
    <div class="imgs-container">
        <div class="row" v-show="images.length>0">
            <div class="col-xs-4" v-for="item in images">
                <img :src="item.link" class="small-img img-responsive"
                     alt="" @click.prevent="clickImage(item)">
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            images:{
                type:Array
            }
        },
        methods:{
            clickImage: function (image) {
                this.$dispatch('changeLargeImageContainer', image)
            }
        }
    }
</script>