<style>
    div.coverDescription{
        background-color: red;
    }
</style>
<template>
    <div class="description">
        About Room
        <div :class="{'coverDescription':isTooMuch}" v-html="description"></div>
    </div>
</template>

<script>
    export default{
        props:{
            description:{
                type: String
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