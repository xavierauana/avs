<style></style>
<template>
    <li @click="changeView" :class="{'active':isCurrentView}">
        <slot>Button</slot>
    </li>
</template>

<script>
    export default{
        props:{
            view:{
                type: String
            },
            currentView:{
                type: String
            },
            buttonText:{
                type: String
            }
        },
        computed:{
            isCurrentView: function(){
                return this.view == this.currentView
            }
        },
        methods:{
            changeView: function(){
                this.$dispatch('updateProperty');
                this.$dispatch('changeView', this.view);
            }
        }
    }
</script>