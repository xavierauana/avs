<style></style>
<template>
    <div class="location-container">
    <div class="map-container">
        <div id="map"></div>
    </div>
    </div>
</template>

<script>
    var GoogleMapsAPI = require('googlemaps');
    export default{
        props: {
            address: {
                type: Object,
                default: function () {
                    return {}
                },
                required: true
            }
        },
        data: function () {
            return {
                config: {
                    key: 'AIzaSyDcuVH7UBoLjGkZ6_O2RHlrVbWUwr6zmXA',
                    stagger_time: 1000, // for elevationPath
                    encode_polylines: false,
                    secure: false // use https
                },
                params: {
                    center: "",
                    zoom: 14,
                    size: '5000x400',
                    markers: [
                        {
                            location: "",
                            label: "A"
                        }
                    ]
                }
            }
        },
        watch: {
            address: function (value) {
                if (Object.keys(value).length > 0) {
                    var address = this.address.street + ',' + this.address.city + ',' + this.address.country;
                    this.params.center = address;
                    this.params.markers[0].location = address;
                    this.createMap()
                }
            }
        },
        methods: {
            createMap: function () {
                var gmAPI = new GoogleMapsAPI(this.config),
                        url = gmAPI.staticMap(this.params),
                        img = document.createElement('img');

                console.log(url);

                img.src = url;
                img.className = 'img-responsive';
                document.getElementById('map').appendChild(img);
            }
        }
    }
</script>