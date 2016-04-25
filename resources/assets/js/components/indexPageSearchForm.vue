<style src="style/indexPage.css"></style>
<template>
    <section class="indexPageSearchForm">
        <form class="form-inline" method="get" @submit.prevent="getAvailableProperties">
            <div class="form-group">
                <label class="sr-only" for="checkInDate">Check In Date</label>
                <date id="checkInDate" :date.sync="checkInDate" :min="today"></date>
            </div>
            <div class="form-group">
                <label class="sr-only" for="checkOutDate">Check Out Date</label>
                <date id="checkOutDate" :date.sync="checkOutDate" :min="checkInDate"></date>
            </div>
            <div class="form-group">
                <label class="sr-only" for="occupancy">Email address</label>
                <select class="form-control" name="occupancy" id="occupancy" v-model="occupancy">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="form-group">
                <label class="sr-only" for="submit">Submit</label>
                <input class="form-control" name="submit" type="submit" value="Search" id="submit"/>
            </div>
        </form>
    </section>
</template>

<script>
    import Date from './date.vue'
    var moment = require('moment');

    export default {
        data: function () {
            return {
                occupancy: 1,
                destination: 'hong kong',
                checkInDate: "",
                checkOutDate: "",
                today: moment().format("YYYY-MMM-D")
            }
        },
        computed: {
            dataParams: {
                min: 'today',
                max: ""
            }
        },
        components: {
            Date
        },
        methods: {
            constructUri: function () {
                var fields = [
                    'destination', 'checkIn', 'checkOut', 'occupancy'
                ]
                var data = {
                    checkIn: this.parseDate(this.checkInDate),
                    checkOut: this.parseDate(this.checkOutDate),
                    occupancy: this.occupancy,
                    destination: "Hong Kong"
                }

                var uri = fields.reduce(function (previousResult, query) {
                            return previousResult += query + "=" + encodeURIComponent(data[query]) + "&"
                        }, '/property?');
                uri = uri.slice(0, -1);
                return uri;
            },
            getAvailableProperties: function () {
                this.$router.go(this.constructUri())
            }
        },
        ready: function () {
            console.log('ready from index page form')
        }
    }
</script>