<style></style>
<template>
    <div>
        <div class="row">
            <div class="col-xs-3">
                <h4 class="sub-title">
                    Date
                </h4>
            </div>
            <div class="col-xs-3">
                <date :date="checkInDate" :min="today"></date>
            </div>
            <div class="col-xs-3">
                <date :date="checkOutDate" :min="checkInDate"></date>
            </div>
            <div class="col-xs-3">
                <select class="form-control" name="accommodates" id="accommodates" v-model="occupancy">
                    <option value="1">1 guest</option>
                    <option value="2">2 guests</option>
                    <option value="3">3 guests</option>
                    <option value="4">4 guests</option>
                    <option value="5">5 guests</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <h4 class="sub-title">
                    Room Type
                </h4>
            </div>
            <div class="col-xs-9">
                <select class="form-control" name="numberOfGuest" v-model="selectedPropertyType">
                    <option value="" selected>Filter by room type</option>
                    <option v-for="type in propertyTypes" :value="type">{{type.label}}</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <h4 class="sub-title">
                    Price Range
                </h4>
            </div>
            <div class="col-xs-9">
                    <range-slider :start="sliderPrices.min" :end="sliderPrices.max"></range-slider>
            </div>
        </div>
    </div>
</template>

<script>
    import Date from './date.vue'
    import RangeSlider from './rangeSlider.vue'
    var moment = require('moment');

    export default{
        props:{
            sliderPrices:{},
            propertyTypes:"",
            selectedPropertyType:"",
            occupancy:""
        },
        created: function(){
          this.$http.get('/api/getPropertyTypes').then(function(response){
              this.$set('propertyTypes', response.data.propertyTypes);
          })
        },
        watch:{
            occupancy: function(value){
                this.$route.query.occupancy = value;
                var uri =window.location.pathname+'?';
                for(var key in this.$route.query){
                    if(this.$route.query[key]){
                        uri = uri+key+"="+encodeURIComponent(this.$route.query[key])+"&"
                    }
                }
                uri = uri.slice(0, -1);
                this.$router.go(uri)

            }
        },
        data: function () {
            return {
                checkInDate: moment(this.$route.query.checkIn, 'D/MM/YYYY').format('YYYY-MMM-D'),
                today: moment().format('YYYY-MMM-D'),
                checkOutDate: moment(this.$route.query.checkOut, 'D/MM/YYYY').format('YYYY-MMM-D'),
                test:""
            }
        },
        components: {
            Date,
            RangeSlider
        }
    }
</script>