<template>
    <div class="header-img-container">
        <!-- This carousel section is only use in index page -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <carousel-item v-for="item in carouselItems" :class="{'active':$index==0}" :item="item"></carousel-item>
            </div>
        </div>
        <!-- end of carousel section -->
        <div class="container second-navbar-container center-block">
            <nav class="navbar" id="second-navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><img src="imgs/logo_sm.png" alt=""></a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="">About Us</a></li>
                    <li><a href="">Whats News</a></li>
                    <li><a href="">House</a></li>
                    <li><a href="">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    import CarouselItem from "./../components/front/partials/carouselItem.vue"
    export default{
        props:{
            carouselItems:{
                type: Array
            }
        },
        components:{
            CarouselItem
        }
    }
</script>