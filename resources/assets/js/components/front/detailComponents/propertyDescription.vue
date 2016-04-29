<style>
    div.propertyDescription {
        overflow: hidden;
    }

    div.coverDescription {
        height: 200px;
    }

    div.coverDescription.showMore {
        height: auto;
    }
</style>
<template>
    <div class="description">
        <h3>About The Property</h3>
        <div class="propertyDescription" :class="{'coverDescription':isTooMuch, 'showMore':wantToShowMore}"
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
                if (numOfRow > 5 || this.description.length > 200) {
                    return true;
                }
                return false
            }
        }
    }
</script>