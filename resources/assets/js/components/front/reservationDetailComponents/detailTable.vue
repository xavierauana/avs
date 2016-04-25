<style></style>
<template>
    <div>
        <h1 class="page-title">
            Reservation for {{getPropertyName}}
        </h1>
        <table class="table">
            <tr>
                <td>
                    Check In Date:
                </td>
                <td>
                    {{getCheckInDate}}
                </td>
            </tr>
            <tr>
                <td>
                    Check Out Date:
                </td>
                <td>
                    {{getCheckOutDate}}
                </td>
            </tr>
            <tr>
                <td>
                    Reservation Make On:
                </td>
                <td>
                    {{getCreationDate}}
                </td>
            </tr>
            <tr>
                <td>
                    Number of Occupancy:
                </td>
                <td>
                    {{getOccupancy}}
                </td>
            </tr>
            <tr>
                <td>
                    Total Payment:
                </td>
                <td>
                    HK$ {{getBilledAmount}}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    var moment = require('moment');

    export default{
        props:{
          reservation:{
              type:Object,
              required:true
          }
        },
        computed:{
            getPropertyName:function(){
                return this.isEmpty(this.reservation)? "":this.reservation.property.name;
            },
            getCheckInDate:function(){
                return this.isEmpty(this.reservation)? "":this.prettyDate(this.reservation.check_in);
            },
            getCheckOutDate:function(){
                return this.isEmpty(this.reservation)? "":this.prettyDate(this.reservation.check_out);
            },
            getCreationDate:function(){
                return this.isEmpty(this.reservation)? "":this.prettyDate(this.reservation.created_at);
            },
            getOccupancy:function(){
                return this.isEmpty(this.reservation)? "":this.reservation.occupancy;
            },
            getBilledAmount:function(){
                var amount = this.isEmpty(this.reservation)? 0:this.reservation.reservation_nights.reduce(function(previousResult,night){
                    return previousResult + night.room_type.base_price;
                },0);

                return amount.toLocaleString();
            }
        },
        methods:{
            prettyDate: function (date) {
                return moment(date).format('dddd, Do MMMM YYYY');
            }
        }
    }
</script>