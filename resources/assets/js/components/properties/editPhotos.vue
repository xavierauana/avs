<style src="./style/editPhotos.css"></style>
<template>
    <div>
        <h1 class="text-center">Photos can bring your space to life</h1>
        <p class="text-center">Add photos of areas guests have access to. You can always come back later and add more.</p>
        <button class="btn btn-lg btn-default" @click.prevent="triggerFileInput"><i class="fa fa-cloud-upload"></i> Add Photo</button>
        <hr>
        <form class="form">
            <fieldset>
                <div class="row">
                    <image-card v-show="hasMedia" v-for="item in property.media" :media.sync="item"></image-card>

                    <div class="col-sm-3 col-xs-6 image-card add-new-photo"  @click.prevent="triggerFileInput">
                        <i class="fa fa-picture-o fa-2x"></i>
                        <div class="add-card-text">+Add Photo</div>
                    </div>
                </div>
                <input @change="upload" type="file" style="display: none;" id="files" accept="image/*" multiple>
            </fieldset>
            <next-button view="EditPricing"></next-button>
        </form>
    </div>
</template>

<script>
    import NextButton from "./nextButton.vue"
    import ImageCard from "./imageCard.vue"
    export default{
        http:{
          headers:{
              "X-CSRF-TOKEN": document.getElementById('csrf-token').getAttribute('content')
          }
        },
        props:{
            property:{
                type: Object,
                twoWay: true
            }
        },
        computed:{
            hasMedia:function(){
                return this.property.media.length > 0
            }
        },
        events:{
            'deleteMediaItem': function(media){
                this.delete(media);
            },
            'updateMediaDescription': function(media){
                this.updateDescription(media);
            }
        },
        methods:{
            triggerFileInput: function(){
                document.getElementById('files').click()
            },
            upload: function(){
                var files = document.getElementById('files').files;
                if(files.length > 0){
                    for(key in files){
                        if(files[key] instanceof File && files[key].size>0){
                            var data = new FormData;
                            data.append('propertyId', this.property.id);
                            data.append('file', files[key]);
                            this.$http.post('/api/properties/uploadPic', data).then(function(response){
                                this.property.media.push(response.data.media);
                               console.log(response.data.message)
                            });
                        }
                    }
                }
            },
            delete: function(media){
                this.$http.delete('/api/properties/'+this.property.id+'/deleteMedia/'+media.id+'/properties').then(function(response){
                    if(response.data.message == 'deleted'){
                        this.property.media.$remove(media);
                    }
                });
            },
            updateDescription: function(media){
                console.log(media.description);
                var data = new FormData;
                data.append('description', media.description);
                this.$http.post('/api/properties/'+this.property.id+'/updatePicDescription/'+media.id, data).then(function(response){
                    console.log(response.data.message)
                });
            }
        },
        components:{
            NextButton,
            ImageCard
        }
    }
</script>