<style>
    div.property-card {
        margin-bottom: 15px;
        height: 200px;
        overflow: hidden;
    }

    div.property-card img {
        width: 100%
    }

</style>
<template>
    <div class="col-xs-6 col-sm-4 col-md-3 property-card"
         @click.prevent="goToDetail">
        <img :src="getPropertyImage()" class="" alt="">
        <p class="property-description" >{{property.name}}</p>
    </div>
</template>

<script>
    export default{
        props: {
            property: {
                type: Object
            }
        },
        computed: {
            propertyDescription: function () {
                var maxChar = 50;
                return this.property.descriptionHtml.length > maxChar ?
                        this.property.descriptionHtml.substr(0, maxChar) :
                        this.property.descriptionHtml;
            }
        },
        methods: {
            goToDetail: function () {
                this.$dispatch('propertyClick', this.property)
            },
            getPropertyImage: function () {
                if (this.property.media.length > 0) {
                    return this.property.media[0].link
                }
            }
        }
    }
</script>