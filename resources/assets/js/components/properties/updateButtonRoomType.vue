<style></style>
<template>
    <button class="btn btn-primary btn-lg pull-right" @click.prevent="clickNextButton">{{buttonText}}</button>
</template>

<script>
    export default{
        props:{
            view:{
                type: String,
                default:""
            }
        },
        computed:{
            buttonText: function(){
                return this.view == ""? 'Save': 'Next';
            }
        },
        methods:{
            clickNextButton: function(){
                this.$dispatch('updateRoomType');
                if(this.view != ""){
                    this.$dispatch('changeView', this.view);
                }else{
                    this.$router.go({
                        name:'editRoomType',
                        params:{
                            roomType_id: this.$route.params.roomType_id
                        }
                    });
                }
            }
        }
    }
</script>