<style src="./style/detail.css"></style>
<template>
    <div id="price">
        <p class="text-right">HK$ <span id="nightRate">{{activePrice}}</span></p>
        <h5 v-show="isMultiple">{{activeLabel}}</h5>
        <input type="text" class="form-control" name="promoCode" value="" placeholder="Promotion Code">
        <button id="bookingButton" class="btn btn-lg btn-block" @click.prevent="bookNow">
            Book Now
        </button>
        <button name="submit" class="btn btn-lg btn-block" @click.prevent="messageOwner">
            Message Owner
        </button>
        <button class="btn btn-default btn-lg btn-block" :class="{'active':inWishList}"
                @click.prevent="toggleWishListItem">
            <i class="fa fa-heart-o"></i>
            <span>Save to your wish list</span>
        </button>
        <modal :show.sync="bookingModalShow">
            <span slot="header">Make A Booking</span>

            <div slot="body">
                <date :date.sync="checkInDate" :min="today" placeholder="Check In Date"></date>
                <date :date.sync="checkOutDate" :min="checkInDate" placeholder="Check Out Date"></date>
                <div class="form-group">
                    <label for="">Occupancy</label>
                    <select name="" id="" class="form-control" v-model="occupancy">
                        <option v-for="number in 6" :value="number+1">{{number+1}}</option>
                    </select>
                </div>
            </div>
            <div slot="footer">
                <button class="btn btn-default" @click.prevent="bookingModalShow=false">Cancel</button>
                <button class="btn btn-default" @click.prevent="makeReservation">Book</button>
            </div>
        </modal>
        <modal :show.sync="messageModalShow">
            <span slot="header">Message Property Owner</span>
            <textarea slot="body" placeholder="I want to say..." v-model="message"></textarea>

            <div slot="footer">
                <button class="btn btn-default" @click.prevent="messageModalShow=false">Cancel</button>
                <button class="btn btn-default" @click.prevent="sendMessage">Send</button>
            </div>
        </modal>
        <sign-in-modal :show.sync="singInModalShow" :auth.sync="auth" :user.sync="user"></sign-in-modal>
        <modal :show.sync="bookSuccessful">
            <span slot="header">You have successful make the booking</span>
            <div slot="body">
                Thank you for booking with us!
            </div>
        </modal>
    </div>
</template>

<script>
    var moment = require('moment');
    import  Modal from './../modal.vue';
    import  Date from './../date.vue';
    import SignInModal from './../signInModal.vue'

    export default{
        props: {
            property: {
                type: Object
            },
            user: {
                type: Object,
                twoWay: true
            },
            auth: {
                type: Boolean
            }
        },
        data: function () {
            return {
                checkInDate: "",
                checkOutDate: "",
                occupancy: "",
                queryOccupancy: this.$route.query.occupancy,
                selectedRoomType: {},
                messageModalShow: false,
                bookingModalShow: false,
                singInModalShow: false,
                bookSuccessful: false,
                message: "",
                today: moment().format("YYYY-MMM-D"),
                nightRate: "",
                roomTypeLabel: ""
            }
        },
        events: {
            "change-room-type": function (roomType) {
                this.$set('selectedRoomType', roomType);
                this.$set('nightRate', roomType.base_price);
                this.$set('roomTypeLabel', roomType.type.label);
            }
        },
        watch: {
            property: function () {
                this.setRoomType();
            }
        },
        computed: {
            activeLabel:function(){
                if(Object.keys(this.selectedRoomType).length > 0){
                    return this.selectedRoomType.type.label
                }
            },
            activePrice:function(){
                if(Object.keys(this.selectedRoomType).length > 0){
                    return this.selectedRoomType.base_price
                }
            },
            isMultiple: function () {
                if (this.isValid(this.property.property_type)) {
                    return this.property.property_type.is_multiple && this.property.room_types.length > 1;
                }
            },
            inWishList: function () {
                var check = false;
                if (typeof this.user.wishListItems != 'undefined') {
                    check = this.user.wishListItems.indexOf(parseInt(this.$route.params.property_id)) > -1;
                }
                return check;
            }
        },
        methods: {
            setRoomType: function () {
                if (this.isMultiple) {
                    this.$set('selectedRoomType', this.getFirstProperRoomType());
                } else {
                    this.$set('selectedRoomType', this.property.room_types[0]);
                }
            },

            getFirstProperRoomType: function () {
                if (this.isValid(this.property.room_types)) {
                    return this.property.room_types.filter(function (room) {
                        return room.occupancy >= this.queryOccupancy;
                    }.bind(this))[0];
                }
            },
            getFirstProperRoomTypeLabel: function () {
                var occupancy = this.$route.query.occupancy;
                if (this.isValid(this.property.room_types)) {
                    return this.property.room_types.filter(function (room) {
                        return room.occupancy >= occupancy;
                    })[0].type.label;
                }
            },
            getFirstProperRoomTypePrice: function () {
                var occupancy = this.$route.query.occupancy;
                if (this.isValid(this.property.room_types)) {
                    return this.property.room_types.filter(function (room) {
                        return room.occupancy >= occupancy;
                    })[0].base_price
                }
            },
            whichRoomType: function () {
                console.log(this.$route.query.occupancy == 1);
            },
            sendMessage: function () {
                data = {
                    message: this.message,
                    propertyId: this.property.id
                };
                this.apiSendMessage(data).then(function (response) {
                    console.log(response.message);
                });
            },
            toggleWishListItem: function () {
                if (this.isAuthenticated()) {
                    this.$http.get('/api/wishList/' + this.$route.params.property_id).then(function (response) {
                        if (response.data.action == 'add') this.user.wishListItems.push(parseInt(this.$route.params.property_id));
                        if (response.data.action == 'remove') this.user.wishListItems.splice(this.user.wishListItems.indexOf(parseInt(this.$route.params.property_id)), 1);
                    })
                }
            },
            bookNow: function () {
                if (this.isAuthenticated()) {
                    this.$set('bookingModalShow', true);
                }
            },
            messageOwner: function () {
                if (this.isAuthenticated()) {
                    this.$set('messageModalShow', true);
                }
            },
            propertyIsLoaded: function () {
                return Object.keys(this.property).length > 0;
            },
            isSinglePropertyType: function () {
                if (this.propertyIsLoaded()) {
                    if (this.property.property_type.is_multiple == 0) {
                        return true
                    }
                }
                return false
            },
            makeReservation: function (event) {
                event.target.setAttribute('disabled', true);
                var data = {
                    checkInDate: this.checkInDate,
                    checkOutDate: this.checkOutDate,
                    occupancy: this.occupancy,
                    roomTypeId: this.selectedRoomType.id
                };
                this.apiMakeReservation(data).then(function (response) {
                    event.target.removeAttribute('disabled');
                    if(response.data.completed == 'okay'){
                        swal(response.data.message)
                        this.bookingModalShow = false;
                    }else if(response.data.completed == 'error'){
                        swal(response.data.message)
                    }
                });
            }
        },
        components: {
            Modal,
            SignInModal,
            Date
        },
        ready: function () {
            if (this.isValid(this.$route.query.checkIn)) this.$set('checkInDate', moment(this.$route.query.checkIn, "DD/MM/YYYY").format('YYYY-MMM-DD'));
            if (this.isValid(this.$route.query.checkOut)) this.$set('checkOutDate', moment(this.$route.query.checkOut, "DD/MM/YYYY").format('YYYY-MMM-DD'));
            if (this.isValid(this.$route.query.occupancy)) this.$set('occupancy', this.$route.query.occupancy);
        }
    }
</script>