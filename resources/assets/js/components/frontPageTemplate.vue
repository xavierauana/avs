<style>

</style>
<template>
    <div class="container-fluid">
        <header-nav-bar :user="user" :auth="auth">
            <slot name="header-carousel"></slot>
        </header-nav-bar>
        <slot name="content"></slot>
    </div>
</template>

<script>

    import HeaderNavBar from './front/partials/headerNavBar.vue';
    export default{
        props:{
            user:{
                type:Object,
                required:true,
                default: function(){
                    return {}
                }
            },
            auth:{
                type: Boolean,
                required:true,
                default: false
            }
        },
        components:{
            HeaderNavBar
        }
    }
</script>