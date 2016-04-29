<style>
    div.propertyDescription {
        overflow: hidden;

    }

    div.coverDescription {
        position: relative;
        height: 200px;
        }
    div.coverDescription:after {
        content: " ";
        z-index: 10;
        display: block;
        position: absolute;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#1e5799+0,ffffff+100&0+0,1+100 */
        background: -moz-linear-gradient(top,  rgba(30,87,153,0) 0%, rgba(255,255,255,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(30,87,153,0) 0%,rgba(255,255,255,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(30,87,153,0) 0%,rgba(255,255,255,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#001e5799', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
    }

    div.coverDescription.showMore {
        height: auto;
    }
</style>
<template>
    <div class="description">
        <h3>About The Property</h3>
        <div class="propertyDescription" :class="{'coverDescription':isTooMuch && !wantToShowMore, 'showMore':wantToShowMore}"
             v-html="description"></div>
        <button class=" btn btn-xs btn-block btn-info" @click="wantToShowMore = true"
                v-show="isTooMuch && !wantToShowMore"> Show More
        </button>
    </div>
</template>

<script>
    export default{
        props: {
            description: {
                type: String
            }
        },
        data: function () {
            return {
                wantToShowMore: false
            }
        },
        computed: {
            isTooMuch: function () {
                var numOfRow = (this.description.match(/<br\/>|<br \/>/g) || []).length;
                return numOfRow > 5 || this.description.length > 200
            }
        }
    }
</script>