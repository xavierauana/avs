<style>
    div.list {
        background-color: white;
    }

    .property-card {
        cursor: pointer;
    }

    .property-card p.property-description {
        position: absolute;
        display: block;
        width: 100%;
        margin: 0;
        background-color: rgba(255, 255, 255, 0.8);
        bottom: 0;
        left: 15px;
    }
</style>
<template>
    <front-page-template :user="user" :auth="auth" keep-alive>
        <div slot="content" class="container list">
            <section>
                <h1 class="page-title">
                    House
                </h1>
                <detail-search-form :slider-prices="sliderPrices"
                                    :property-types.sync="propertyTypes"
                                    :occupancy.sync="occupancy"
                                    :selected-property-type.sync="selectedPropertyType"
                ></detail-search-form>
            </section>
            <div v-show="properties.length">
                <div class="row">
                    <property-in-list
                            v-for="property in properties | priceFilter | propertyTypeFilter"
                            :property="property"
                    ></property-in-list>
                </div>
            </div>
        </div>
    </front-page-template>
</template>

<script>
    import Date from './../date.vue'
    import DetailSearchForm from './../detailSearchForm.vue'
    import HeaderNavBar from './../front/partials/headerNavBar.vue'
    import FrontPageTemplate from './../frontPageTemplate.vue'
    import PropertyInList from "./../front/partials/propertyInList.vue"

    export default {
        route: {
            data: function (transition) {
                swal({
                    title: "",
                    text: "Loading properties ...",
                    showConfirmButton: false
                });
                this.authorization();
                this.$http.get(this.constructUrl())
                        .then(function (response) {
                            this.$set('properties', response.data.properties);
                            this.sliderPrices.min = this.getMinRoomPrice();
                            this.sliderPrices.max = this.getMaxRoomPrice();
                            this.sliderPrices.low = this.getMinRoomPrice();
                            this.sliderPrices.high = this.getMaxRoomPrice();
                            swal.close();
                            transition.next();
                        })
            }
        },
        data: function () {
            return {
                properties: [],
                roomType: "",
                propertyTypes: [],
                selectedPropertyType: {},
                occupancy: this.$route.query.occupancy,
                user: {},
                auth: false,
                sliderPrices: {
                    min: "",
                    max: "",
                    low: "",
                    high: ""
                }
            }
        },
        watch: {
            user: function (value) {
                this.$dispatch('userChanged', value);
            },
            auth: function (value) {
                this.$dispatch('authChanged', value);
            },
        },
        directives: {
            Date
        },
        events: {
            sliderStartChange: function (newValue) {
                this.sliderPrices.low = newValue;
            },
            sliderEndChange: function (newValue) {
                this.sliderPrices.high = newValue;
            },
            propertyClick: function (property) {
                this.goToDetail(property);
            },
            topLevelUserUpdated: function (user) {
                this.$set('user', user);
            },
            topLevelAuthUpdated: function (auth) {
                this.$set('auth', auth);
            }
        },
        components: {
            FrontPageTemplate,
            DetailSearchForm,
            HeaderNavBar,
            PropertyInList
        },
        filters: {
            maxCharLength: function (value, maxLength) {
                if (value.length > maxLength) {
                    value = value.substring(0, maxLength);
                }
                return value;
            },
            priceFilter: function (properties) {
                var self = this;
                return properties.filter(function (property) {
                    var propertyRoomType = property.room_types.filter(function (room_type) {
                        if (room_type.base_price >= self.sliderPrices.low && room_type.base_price <= self.sliderPrices.high) {
                            return room_type;
                        }
                    });
                    if (propertyRoomType.length > 0) return property;
                })
            },
            occupancyFilter: function (properties) {
                var self = this;
                return properties.filter(function (property) {
                    var propertyRoomType = property.room_types.filter(function (room_type) {
                        if (room_type.occupancy >= self.occupancy) {
                            return room_type;
                        }
                    });
                    if (propertyRoomType.length > 0) return property;
                })
            },
            propertyTypeFilter: function (value) {
                if (this.selectedPropertyType) {
                    return value.filter(function (property) {
                        if (property.property_type.code == this.selectedPropertyType.code) return property
                    }.bind(this))
                }
                return value;
            }
        },
        methods: {
            getMaxRoomPrice: function () {
                var maxPrice = 0;
                this.properties.map(function (property) {
                    property.room_types.map(function (room) {
                        maxPrice = room.base_price > maxPrice ? room.base_price : maxPrice;
                    })
                });

                return maxPrice;
            },
            getMinRoomPrice: function () {
                var minPrice = 1000000;
                this.properties.map(function (property) {
                    property.room_types.map(function (room) {
                        minPrice = room.base_price < minPrice ? room.base_price : minPrice;
                    })
                });

                return minPrice;
            },
            goToDetail: function (property) {
                var url = '/property/' + property.id;
                if (typeof this.$route.query.checkIn != 'undefined' && typeof this.$route.query.checkOut != 'undefined') {
                    url = url + "?checkIn=" + encodeURIComponent(this.$route.query.checkIn) + "&checkOut=" + encodeURIComponent(this.$route.query.checkOut)
                }
                if (typeof this.$route.query.occupancy != 'undefined') {
                    url = url + "&occupancy=" + encodeURIComponent(this.$route.query.occupancy)
                }
                this.$router.go(url);
            },
            constructUrl: function () {
                var url, query;

                query = "";
                for (var key in this.$route.query) {
                    if (this.$route.query[key]) {
                        query = query + key + "=" + encodeURIComponent(this.$route.query[key]) + "&"
                    }
                }
                query = query.slice(0, -1);

                url = "/api/searchProperties?" + query;
                return url
            }
        }
    }
</script>