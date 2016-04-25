<template>
    <header-nav-bar>
        <header-carousel></header-carousel>
    </header-nav-bar>
</template>

<script>

    import HeaderCarousel from './headerCarousel.vue'
    import HeaderNavBar from './front/partials/headerNavBar.vue'
    export default {
        data:function(){
            return {
                showModal:false
            }
        },
        ready:function(){
            console.log('from front end header')
        },
        components:{
            HeaderCarousel,
            HeaderNavBar
        }
    }
</script>