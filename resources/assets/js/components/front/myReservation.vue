<style src="./style/detail.css"></style>
<template>
    <front-page-template :user="user" :auth="auth">
        <div slot="content" class="container" id="house_detail">
            <h1 class="page-title">
                My Reservations
            </h1>
            <ul class="list-unstyled">
                <li v-show="reservations.length==0">
                    You don't have any reservations now!
                </li>
                <li v-for="reservation in reservations" >
                    <reservation
                            :reservation="reservation"></reservation>
                </li>
            </ul>
            <br>
        </div>
    </front-page-template>
</template>

<script>
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import Reservation from './reservationComponents/reservation.vue'

    export default{
        route: {
            data: function () {
                this.authorization();
                this.apiGetReservations().then(function(response){
                    if(this.isValid(response.data.reservations)){
                        this.$set('reservations', response.data.reservations)
                    }
                })
            }
        },
        data: function () {
            return {
                reservations:[],
                user: {},
                auth: false
            }
        },
        events:{
            topLevelUserUpdated:function(user){
                this.$set('user', user);
            },
            topLevelAuthUpdated:function(auth){
                this.$set('auth', auth);
            }
        },
        components:{
            FrontPageTemplate,
            Reservation
        }
    }
</script>