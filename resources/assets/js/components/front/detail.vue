<style src="./style/detail.css"></style>
<template>
    <front-page-template :user.sync="user" :auth.sync="auth">
        <div slot="content" class="container" id="house_detail">
            <h1 class="page-title">
                Detail
                <small v-show="isOwner"><a :href="'/properties/manage-listing/'+$route.params.property_id">edit</a>
                </small>
            </h1>
            <section>
                <property-name
                        :property-name="getPropertyName"
                        :property-address="getPropertyAddress"
                ></property-name>
            </section>
            <section>
                <div class="col-sm-8">
                    <large-image-container
                            :img-src="enlargeImgSrc">

                    </large-image-container>
                    <property-icons
                            :property-type="getPropertyType"
                            :occupancy="getOccupancy"
                            :beds="getBeds"
                    ></property-icons>

                    <property-description
                            :description="getPropertyDescription"
                    ></property-description>
                    <hr>
                    <facilities
                            :facilities="getPropertyFacilities"
                    ></facilities>
                    <br>

                    <room-type-blocks
                            v-show="isMultiple"
                            :property="property"></room-type-blocks>

                    <g-map :address="property.address | passObject"></g-map>

                </div>
                <div class="col-sm-4">
                    <property-images
                            :images="getPropertyMedia"
                    ></property-images>
                    <actions-block :property="property" :user.sync="user" :auth.sync="auth"></actions-block>
                </div>
                <hr>
            </section>
            <br>
        </div>
    </front-page-template>
</template>

<script>
    "use strict";

    import SignInModal from './../signInModal.vue'
    import Modal from './../modal.vue'
    import GMap from './../googleMap.vue'
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import ActionsBlock from './actionsBlock.vue'
    import RoomTypeBlocks from './roomTypeBlocks.vue'
    import PropertyName from './detailComponents/propertyName.vue'
    import LargeImageContainer from './detailComponents/largeImageContainer.vue'
    import PropertyIcons from './detailComponents/basicPropertyIcons.vue'
    import PropertyDescription from './detailComponents/propertyDescription.vue'
    import Facilities from './detailComponents/propertyFacilities.vue'
    import PropertyImages from './detailComponents/propertyImages.vue'

    export default{
        route: {
            data: function () {
                if (typeof this.$route.params.property_id === 'undefined') this.$router.go('/');
                swal({
                    title: "Loading ...",
                    type: "",
                    showConfirmButton: false
                });
                this.authorization();
                this.$http.get('/api/getTheProperty/' + this.$route.params.property_id).then(function (response) {
                    swal.close();
                    this.$set('property', response.data.property)
                    if (this.property.media.length > 0) {
                        this.$set('enlargeImgSrc', this.property.media[0].link)
                    }
                }, function (response) {
                    swal({
                        title: "Ops..",
                        text: "Unable to found listing!",
                        type: "error",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(function () {
                        this.$router.go('/');
                    }.bind(this), 1700)
                });
                this.$http.get('/api/isPropertyOwner/' + this.$route.params.property_id).then(function (response) {
                    this.$set('isOwner', response.data.isPropertyOwner)
                });
            }
        },
        data: function () {
            return {
                isOwner: false,
                raw: {},
                property: {},
                user: {},
                auth: false,
                enlargePic: "",
                message: "",
                enlargeImgSrc: ""
            }
        },
        events: {
            'change-room-type': function (roomType) {
                console.log('event handled by detail');
                this.$broadcast('change-room-type', roomType);
            },
            changeLargeImageContainer: function (image) {
                this.$set('enlargeImgSrc', image.link)
            },
            topLevelUserUpdated:function(user){
                this.$set('user', user);
            },
            topLevelAuthUpdated:function(auth){
                this.$set('auth', auth);
            }
        },
        watch: {
            property: function () {
                if (this.propertyIsLoaded() && this.property.media.length > 0) {
                    this.$set('enlargePic', this.property.media[0].link)
                }
            },
            user: function (value) {
                console.log('user change from components');
                this.$dispatch('userChanged', value);
            },
            auth: function (value) {
                this.$dispatch('authChanged', value);
            }
        },
        computed: {
            getPropertyFacilities: function(){
                return this.propertyIsLoaded()? this.property.amenities:[]
            },
            getPropertyDescription: function () {
              return this.propertyIsLoaded()? this.property.description:"";
            },
            getPropertyName:function () {
                if(this.propertyIsLoaded()){
                    return this.property.name
                }
                return "";
            },
            getPropertyMedia: function () {
                if (this.propertyIsLoaded()) {
                    return this.property.media
                }
                return []
            },
            isMultiple: function () {
                if (this.isValid(this.property.property_type)) {
                    return this.property.property_type.is_multiple && this.property.room_types.length > 1;
                }
            },
            getOccupancy: function () {
                return this.isSinglePropertyType() ? this.property.room_types[0].occupancy : ""
            },
            getBeds: function () {
                return this.isSinglePropertyType() ? this.property.room_types[0].beds : ""
            },
            getPropertyType: function () {
                return this.propertyIsLoaded() ? this.property.property_type.label : ""
            },
            getNightRate: function () {
                return this.isSinglePropertyType() ? this.property.room_types[0].base_price : ""
            },
            getPropertyAddress: function () {
                if (this.propertyIsLoaded()) {
                    var modified_address = "";
                    modified_address = this.property.address.street != null ? modified_address + this.property.address.street : "";
                    modified_address = this.property.address.city != null ? modified_address + ", " + this.property.address.city : "";
                    modified_address = this.property.address.country != null ? modified_address + ", " + this.property.address.country : "";
                    return modified_address
                }
                return "";
            }
        },
        components: {
            Modal,
            GMap,
            SignInModal,
            FrontPageTemplate,
            ActionsBlock,
            RoomTypeBlocks,
            PropertyName,
            LargeImageContainer,
            PropertyIcons,
            PropertyDescription,
            Facilities,
            PropertyImages
        },
        filters: {
            passObject: function (value) {
                return typeof value == 'object' ? value : {}
            }
        },
        methods: {
            changeLargeImg: function (media) {
                this.$set('enlargePic', media.link);
            },
            redirectToIndexPage: function () {
                this.$router.go('/')
            },
            propertyIsLoaded: function () {
                return Object.keys(this.property).length > 0;
            },
            isSinglePropertyType: function () {
                if (this.propertyIsLoaded()) {
                    if (this.property.property_type.is_multiple == 0) return true
                }
                return false
            }
        },
        ready: function () {
            this.apiGetMessages().then(function (response) {
                console.log(response)
            });
        }

    }
</script>