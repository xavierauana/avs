<template>
    <div>
        <h1 class="text-center">Help guests find your place</h1>
        <p class="text-center">Travelers will use this information to find a place that’s in the right spot.</p>
        <hr>
        <form class="form">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input class="form-control" name="country" id="country" v-model="property.address.country" placeholder="Be clear and descriptive"/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" name="state" id="state" v-model="property.address.state" placeholder=""/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" v-model="property.address.city" placeholder=""/>

                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address" v-model="property.address.street" placeholder=""/>

                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="building">Apt, Suite, Bldg</label>
                            <input type="text" class="form-control" name="building" id="building" v-model="property.address.building" placeholder=""/>
                        </div>
                    </div>
                </div>
            </fieldset>
            <next-button view="EditAmenities"></next-button>
        </form>
        <br>
    </div>
</template>

<script>
    import NextButton from './nextButton.vue';

    export default {
        props: {
            property: {
                type: Object,
                twoWay: true
            }
        },
        components:{
            NextButton
        }
    }
</script>