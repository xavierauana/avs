<style>
    .image-card{
        margin-right: 15px;
        margin-bottom: 15px;
    }
    .image-card:hover section.upper .delete-img-button{
        display: block;
    }
    section.upper{
        margin-left: -15px;
        margin-right: -15px;
        height: 125px;
        background-color: grey;
    }
    section.upper img{
        max-height: 125px;
    }
    section.upper .delete-img-button{
        display: none;
        position: absolute;
        right: 10px;
        top: 10px;
    }
    section.upper .delete-img-button:hover{
        color:red
    }
    section.lower{
        height: 135px;
    }
    section.lower textarea{
        width: 90%;
        margin: 15px;
        height: 105px;
    }
</style>
<template>
    <div class="col-sm-3 col-xs-6 image-card">
        <section class="upper">
            <button class="btn btn-default btn-xs delete-img-button" @click.prevent="deleteItem">Delete</button>
            <img class="img-responsive center-block" :src="media.link" alt="">
        </section>
        <section class="lower">
            <textarea name="description" id="description" @blur="updateNote" v-model="media.description" placeholder="What's this Photo about">{{media.description}}</textarea>
        </section>
    </div>
</template>

<script>
    export default{
        props:{
            media:{
                type:Object,
                twoWay: true
            }
        },
        methods:{
            deleteItem: function(){
                this.$dispatch('deleteMediaItem', this.media)
            },
            updateNote: function(){
                // TODO: verify the following code block
                console.log('update note fire',this.media.description);
                this.$dispatch('updateMediaDescription', this.media)
            }
        }
    }
</script>