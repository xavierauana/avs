<template>
    <span>
        <input type="text" class="form-control date" v-model="date" :placeholder="placeholder">
    </span>
</template>

<script>
    var moment = require('moment');
    export default{
        ready: function () {
            var options = {
                dateFormat: "yy-M-dd",
                minDate: this.min
            };
            $(this.$el.getElementsByTagName('input')[0]).datepicker(options);
        },
        props: {
            date: {
                type: String
            },
            min: {
                type: String
            },
            placeholder:{
                type: String,
                default:""
            }
        },
        watch: {
            min: function (val) {
                var date = new Date(val);
                date.setDate(date.getDate() + 1);
                $(this.$el.getElementsByTagName('input')[0]).datepicker("option", "minDate", date);
            }
        }
    }
</script>