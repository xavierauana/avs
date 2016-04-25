<style></style>
<template>
        <div>
            <h1>Create A New Room Type</h1>
            <component :is="currentView" :property.sync="property"></component>
        </div>
</template>

<script>
    import EditDescription from "./editDescription.vue"
    import EditBasicRoomType from "./editBasicRoomType.vue"
    import EditAmenities from "./editAmenities.vue"
    import EditPricing from "./editPricing.vue"
    import NextButton from "./nextButton.vue"
    export default{
        props:{
            property: Object
        },
        data:function(){
            return {
                currentView:'EditBasicRoomType'
            }
        },
        components:{
            EditDescription,
            EditAmenities,
            EditPricing,
            NextButton,
            EditBasicRoomType
        }
    }
</script>