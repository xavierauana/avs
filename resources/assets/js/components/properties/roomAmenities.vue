<template>
    <div class="col-sm-9">
        <h1 class="text-center">Tell travelers about your space</h1>
        <p class="text-center">Every space is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.</p>
        <hr>
        <form class="form">
            <fieldset v-for="(label, category) in amenities ">
                <legend>{{label}}</legend>
                <div class="row">
                    <div v-for="amenity in category" class="checkbox col-xs-6 col-sm-12">
                        <label>
                            <input type="checkbox" :value="amenity.id" v-model="roomType.amenities" :checked="roomType.amenities.indexOf(amenity)>-1">{{amenity.label}}
                        </label>
                    </div>
                </div>
            </fieldset>
            <next-button></next-button>
        </form>
        <pre>
            {{$data|json}}
        </pre>
    </div>
</template>

<script>
    import NextButton from './updateButtonRoomType.vue'
    export default{
        activate:function(done){
            var url = '/api/properties/getAmenities?hotel=false';
            this.$http.get(url).then(function(response){
                var test = {};
                response.data.amenities.map(function(item){
                    if(item.category in test) {
                        test[item.category].push(item);
                    }else{
                        test[item.category]=[];
                    }
                });
                this.$set('amenities', test);
                done()
            })
        },
        data:function(){
            return {
                amenities:{}
            }
        },
        props:{
            roomType:{
                type: Object,
                twoWay: true
            }
        },
        methods:{
            inPropertyAmenities: function(id){
                return id.indexOf(this.roomType.amenities);
            }
        },
        components:{
            NextButton
        }
    }
</script>