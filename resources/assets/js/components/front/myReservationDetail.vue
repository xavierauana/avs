<style src="./style/detail.css"></style>
<template>
    <front-page-template :user="user" :auth="auth">
        <div slot="content" class="container" id="house_detail">
            <detail-table
                    :reservation="reservation"></detail-table>
        </div>

    </front-page-template>
</template>

<script>
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import DetailTable from './reservationDetailComponents/detailTable.vue';

    export default{
        route: {
            data: function () {
                this.authorization();
                this.apiGetReservations(this.$route.params.reservationId).then(function (response) {
                    if (this.isValid(response.data.reservations)) {
                        this.$set('reservation', response.data.reservations)
                    }
                })
            }
        },
        components: {
            DetailTable
        },
        data: function () {
            return {
                user: {},
                auth: false,
                reservation: {}
            }
        },
        events: {
            topLevelUserUpdated: function (user) {
                this.$set('user', user);
            },
            topLevelAuthUpdated: function (auth) {
                this.$set('auth', auth);
            }
        }
    }
</script>