<style></style>
<template>
    <div class="icons-container text-center">
        <div class="row">
            <p class="col-xs-3 col-xs-offset-2  icons text-center">
                <i class="fa fa-2x fa-home"></i>
                {{propertyType}}
                <br>
            </p>

            <p class="col-xs-3 icons text-center">
                <i class="fa fa-2x fa-users"></i>
                {{occupancy}}
                <br>
            </p>

            <p class="col-xs-3 icons text-center">
                <i class="fa fa-2x fa-bed"></i>
                {{beds}}
                <br>
            </p>
        </div>

    </div>
</template>

<script>
    export default{
        props:{
            propertyType:{
                type: String
            },
            occupancy:{
                type: Number,
                default: 0
            },
            beds:{
                type: Number,
                default: 0
            }
        }
    }
</script>