<style>
    #property-preview{

    }
</style>
<template>
    <div class="img-container">
        <img id="property-preview" class="img-responsive"
             :src="imgSrc"
             alt="">
    </div>
</template>

<script>
    export default{
        props:{
            imgSrc:{
                type:String
            }
        }
    }
</script>