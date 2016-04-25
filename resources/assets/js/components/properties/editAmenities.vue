<template>
    <div>
        <h1 class="text-center">Tell travelers about your space</h1>
        <p class="text-center">Every space is unique. Highlight what makes your listing welcoming so that it stands out to guests who want to stay in your area.</p>
        <hr>
        <form class="form">
            <fieldset v-for="(label, category) in amenities ">
                <legend>{{label}}</legend>
                <div class="row">
                    <div v-for="amenity in category" class="checkbox col-xs-6 col-sm-12">
                        <label>
                            <input type="checkbox" :value="amenity.id" v-model="property.amenities" :checked="property.amenities.indexOf(amenity)>-1">{{amenity.label}}
                        </label>
                    </div>
                </div>
            </fieldset>
            <next-button view="EditPhotos"></next-button>
        </form>
    </div>
</template>

<script>
    import NextButton from './nextButton.vue'
    export default{
        activate:function(done){
            this.$http.get('/api/properties/getAmenities').then(function(response){
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
            property:{
                type: Object,
                twoWay: true
            }
        },
        methods:{
            inPropertyAmenities: function(id){
                return id.indexOf(this.property.amenities);
            }
        },
        components:{
            NextButton
        }
    }
</script>