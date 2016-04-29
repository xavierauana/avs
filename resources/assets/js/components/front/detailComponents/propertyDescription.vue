<style>
    div.coverDescription{
        height: 200px;
    }
    div.coverDescription.showMore{
        height: auto;
    }
</style>
<template>
    <div class="description">
        About Room
        <div :class="{'coverDescription':isTooMuch, 'showMore':wantToShowMore}" v-html="description"></div>
        <div class="text-center" @click="wantTOShowMore = true" v-show="isTooMuch"> Show More </div>
    </div>
</template>

<script>
    export default{
        props:{
            description:{
                type: String
            }
        },
        data:function(){
            return {
                wantTOShowMore:false
            }
        },
        computed:{
            isTooMuch:function () {
                var numOfRow = (this.description.match(/<br\/>|<br \/>/g) || []).length;
                if(numOfRow > 5 || this.description.length > 200){
                    return true;
                }
                return false
            }
        }
    }
</script>