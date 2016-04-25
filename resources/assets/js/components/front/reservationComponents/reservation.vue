<style>
    div.reservation {
        border: 1px solid grey;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    div.getDetailButton{
        margin-bottom:10px;
    }
</style>
<template>
    <div class="col-sm-8 col-md-offset-2 reservation">
        <div class="row">
            <div class="col-xs-4">
                <h4>Reserved Hotel:</h4>
                <p>{{reservation.property.name}}</p>
            </div>
            <div class="col-xs-4">
                <h4>Check in date:</h4>
                <p>{{prettyDate(reservation.check_in)}}</p>
            </div>
            <div class="col-xs-4">
                <h4>Check out date:</h4>
                <p>{{prettyDate(reservation.check_out)}}</p>
            </div>
            <div class="col-xs-12 getDetailButton">
                <a href="#" class="btn btn-default btn-block" v-link="{name: 'myReservationDetail', params:{reservationId:reservation.id }}">Detail</a>
            </div>
        </div>
    </div>
</template>

<script>
    var moment = require('moment');
    export default{
        props: {
            reservation: {
                type: Object,
                required: true
            }
        },
        methods: {
            prettyDate: function (date) {
                return moment(date).format('dddd, Do MMMM YYYY');
            }
        }
    }
</script>