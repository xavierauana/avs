<template>
    <!-- This is the advertisment section 1. This particular section should be only for index page -->
        <section class="advertisment">
        <div class="ad-container" id="ad1">
            <a href="#"><img src="http://lorempixel.com/1440/490/city" alt=""></a>
        </div>
        <div class="ad-container" id="ad2">
            <a href="#"><img src="http://lorempixel.com/1440/490/people" alt=""></a>
        </div>
        <div class="row">
            <div class="col-sm-6 ad-container" id="ad3">
                <a href="#"><img src="http://lorempixel.com/1440/490/sport" alt=""></a>
            </div>
            <div class="col-sm-6 ad-container" id="ad4">
                <a href="#"><img src="http://lorempixel.com/1440/490/abstract" alt=""></a>
            </div>
        </div>
    </section>
    <!-- end of advertisment section 1-->
</template>

<script>
    export default {
        ready: function(){
            console.log("form add 1");
        }
    }
</script>