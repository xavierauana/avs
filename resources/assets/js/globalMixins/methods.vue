/**
* Created by Xavier on 29/1/16.
*/
<script>
    var moment = require('moment');

    export default{
        isObjectLoaded:function(object){
            return Object.keys(object).length > 0;
        },
        setAjaxHeaders:function(){
          return {
                headers:{
                    'X-CSRF-TOKEN': document.querySelector('meta#csrf-token').getAttribute('content')
                }
            }
        },
        getApiEndPoint: function (endPointName) {
            var EndPoint = this.$root.$data.api[endPointName];
            return this.isValid(EndPoint)?  EndPoint:null;
        },
        authorization: function () {
            var url = this.getApiEndPoint('authentication');
            this.$http.get(url,"", this.setAjaxHeaders()).then(function (response) {
                if (response.data.auth) {
                    console.log('is auth response, ', response)
                    this.$dispatch('userChanged', response.data.user);
                    this.$dispatch('authChanged', response.data.auth);
                }
            }, this.ajaxErrorClosure);
        },
        ajaxErrorClosure: function(response){
            swal('Opps...', 'Something error!', 'warning')
        },
        isAuthenticated: function () {
            if (!this.auth) {
                this.singInModalShow = true;
                return false;
            }
            return true;
        },
        isValid: function (variable) {
            return typeof variable != 'undefined' && variable != null
        },
        isEmpty: function(obj){
            if(!this.isValid(obj)) return true;
            if (obj.length > 0)    return false;
            if (obj.length === 0)  return true;
            for (var key in obj) {
                if (hasOwnProperty.call(obj, key)) return false;
            }
            return true;
        },
        parseDate: function (date) {
            return moment(date, "YYYY-MMM-D").format('D/MM/YYYY');
        },
        apiGetReservations: function (reservationId) {
            reservationId = typeof reservationId !== 'undefined' ? reservationId : null;
            var url = '/api/getReservations';
            if(reservationId) url = '/api/getReservations/'+reservationId;
            return this.$http.get(url);
        },
        apiMakeReservation: function (data) {
            var url = '/api/makeReservation';
            return this.$http.post(url, data, this.setAjaxHeaders())
        },
        apiGetMessages: function () {
            var url = '/api/getMessages';
            return this.$http.get(url)
        },
        apiSendMessage: function (data) {
            var url = '/api/message';
            this.$http.post(url, data, this.setAjaxHeaders())
        },
        apiAuth: function(data){
            var url = '/auth/login';
            return this.$http.post(url, data, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('#csrf-token').getAttribute('content')
                }
            })
        },
        apiDeleteProperty: function(data){
            var url = "/api/properties/"+data+'/delete';
            var method = {'_method':'delete'};
            return this.$http.post(url, method, {
                headers:{
                    "X-CSRF-TOKEN": document.querySelector('meta#csrf-token').getAttribute('content')
                }
            })
        },
        apiGetProperties: function(){
            var url = '/api/properties/getProperties';
            return this.$http.get(url)
        }
    }
</script>
