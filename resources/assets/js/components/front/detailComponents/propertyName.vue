<style></style>
<template>
    <div class="col-md-12">
        <h2 id="property-name">
            {{propertyName}}
        </h2>
        <h4 id="property-address">{{propertyAddress}}</h4>
                        <span class='rating pull-right'>
                                <i class="fa fa-star"></i>Rating
                        </span>
    </div>
</template>

<script>
    export default{
        props:{
            propertyName:{
                type: String
            },
            propertyAddress:{
                type: String
            }
        }
    }
</script>