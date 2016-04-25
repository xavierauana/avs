<template>
    <div>
        <h1 class="text-center">Help travelers find the right fit</h1>
        <p class="text-center">People searching can filter by listing basics to find a space that matches their needs.</p>
        <hr>
        <form class="form-horizontal">
            <fieldset>
                <legend>Hotel Information</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Property Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="property.name" placeholder="Property Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" v-model="property.description" placeholder="Description">
                        </textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Address</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="property.address.country" placeholder="Country" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" :value="property.address.city" placeholder="City" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Street</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="property.address.street" placeholder="Street">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Building</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="property.address.building" placeholder="Building">
                    </div>
                </div>

            </fieldset>
            <next-button view="HotelAmenities"></next-button>
        </form>

    </div>
</template>

<script>
    import NextButton from './nextButton.vue';

    export default {
        props:{
            property:{
                type:Object,
                default:function(){
                    return {}
                }
            }
        },
        components:{
            NextButton
        }

    }
</script>