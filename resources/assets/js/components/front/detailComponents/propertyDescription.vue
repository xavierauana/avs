<style></style>
<template>
    <div class="description">
        About Room
        <div v-html="description"></div>
    </div>
</template>

<script>
    export default{
        props:{
            description:{
                type: String
            }
        }
    }
</script>