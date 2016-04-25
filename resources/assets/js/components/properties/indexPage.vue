<style src="./style/indexPage.css"></style>
<template>
    <div class="container-fluid properties-index-page">
        <page-header :user="user"></page-header>
        <div class="container">
            <div class="col-xs-12">
                <div class="col-sm-3">
                    <nav class="">
                        <ul class="list-unstyled">
                            <li><a href="">Your Listing</a></li>
                            <li><a href="">Your Reservation</a></li>
                            <li><a href="/properties/new" v-link="{path:'/properties/new'}"
                                   class="btn btn-sm btn-primary">New Listing</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Listing</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="property-listing list-unstyled">
                                <li class="row property" v-for="property in properties">
                                    <div class="col-sm-3 text-center">
                                        <div class="img-container">
                                            <img :src="getImageLink(property)" class="img-responsive" alt="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled">
                                            <li v-show="property.name" class="property-name"><a
                                                    href="/properties/{{property.id}}">{{property.name}}</a></li>
                                            <li v-show="property.description">{{property.description}}</li>
                                            <li v-show="property.status">{{property.status}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="/properties/manage-listing/{{property.id}}" @click.prevent=""
                                           v-link="{ path:'/properties/manage-listing/'+property.id}"
                                           class="btn btn-default">Edit</a>
                                        <a href="/properties/manage-listing/delete"
                                           @click.prevent="deleteProperty(property)" class="btn btn-danger">Delete
                                            Property</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PageHeader from "./pageHeader.vue"
    export default{
        route: {
            data: function () {
                this.apiGetProperties().then(function (response) {
                    this.$set('properties', response.data)
                });
                this.authorization();
            }
        },
        data: function () {
            return {
                properties: [],
                user: {},
                auth: false
            }
        },
        methods: {
            getImageLink: function (property) {
                return property.media.length > 0 ? property.media[0].link : ""
            },
            deleteProperty: function (property) {
                if (confirm('Are your sure you want to delete the property?')) {
                    this.apiDeleteProperty(property.id).then(function (response) {
                        if (response.ok) {
                            this.properties.$remove(property)
                        }
                    })
                }

            }
        },
        components: {
            PageHeader
        }
    }
</script>