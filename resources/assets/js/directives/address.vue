<script>
    export default{
        bind: function () {
            console.log('demo bound!')
        },
        update: function (address) {
            console.log(address);
            if(typeof address == 'Object'){

            }
            this.el.innerHTML = modified_address;
//                    'name - '       + this.name + '<br>' +
//                    'expression - ' + this.expression + '<br>' +
//                    'argument - '   + this.arg + '<br>' +
//                    'modifiers - '  + JSON.stringify(this.modifiers) + '<br>' +
//                    'value - '      + value
        }
    }
</script>