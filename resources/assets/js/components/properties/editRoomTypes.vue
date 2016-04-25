<style></style>
<template>
    <div>
        <h1>Room Types</h1>
        <component :is="currentView"
                   :property.sync="property"
                   transition="fade"
                   transition-mode="out-in">

        </component>
    </div>
</template>

<script>
    import EditDescription from "./editDescription.vue"
    import EditAmenities from "./editAmenities.vue"
    import EditPricing from "./editPricing.vue"
    import NextButton from "./nextButton.vue"
    import CreateNewRoomType from "./createNewRoomType.vue"
    import RoomTypeList from "./roomTypeList.vue"

    export default{
        props: {
            'property': Object
        },
        activate: function (next) {
            console.log(!!this.property.property_type.is_multiple);
            next();
        },
        data: function () {
            return {
                currentView: 'RoomTypeList'
            }
        },
        events: {
            createNewRoomType: function () {
                this.currentView = "CreateNewRoomType"
            }
        },
        components: {
            EditDescription,
            EditAmenities,
            EditPricing,
            RoomTypeList,
            CreateNewRoomType
        }
    }
</script>