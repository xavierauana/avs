<style></style>
<template>
    <div class="item">
        <img :src="item.src" alt="...">
        <div class="carousel-caption">
            <h1 class="text-center"><span>{{item.title}}</span></h1>
            <p class="text-center"><span>{{item.description}}</span></p>
            <a class="text-center" href="">Read More</a>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            item:{
                type:Object
            }
        }
    }
</script>