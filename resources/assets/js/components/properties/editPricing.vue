<style>
    span.long-term-pricing{
        color:red
    }
</style>
<template>
    <div>
        <h1 class="text-center">Set a nightly price for your space</h1>
        <p class="text-center">You can set a price to reflect the space, amenities, and hospitality you’ll be providing.</p>
        <hr>
        <form class="form">
            <fieldset>
                <legend>Base price</legend>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="base_price">Nightly Price</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control" name="base_price" id="base_price" v-model="property.room_types[0].base_price" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="currency">Currency</label>
                            <select name="currency" id="currency" class="form-control" v-model="property.room_types[0].currency"  disabled>
                                <option value="hkd">HKD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <p v-show="!showLongTermPricing">You can offer discounts for longer stays by setting <span class="long-term-pricing" @click="showLongTermPricing=true">weekly and monthly</span> prices.</p>
                    </div>
                </div>
            </fieldset>
            <fieldset v-show="showLongTermPricing">
                <legend>Long-term prices</legend>
                <p>You might want to charge less for week-long or month-long stays.</p>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="weekly_price">Weekly Price</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control" name="weekly_price" id="weekly_price" v-model="property.room_types[0].weekly_price"  aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="monthly_price">Monthly Price</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="text" class="form-control" name="monthly_price" id="monthly_price" v-model="property.room_types[0].monthly_price"  aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <next-button></next-button>
        </form>
    </div>
</template>

<script>
    import NextButton from './nextButton.vue';
    export default{
        props:{
            property:{
                type: Object,
                twoWay: true
            }
        },
        data:function(){
            return {
                showLongTermPricing: false
            }
        },
        components:{
            NextButton
        }
    }
</script>