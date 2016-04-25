<template>
    <div>
        <h1 class="text-center">Tell travelers about your space</h1>

        <p class="text-center">Every space is unique. Highlight what makes your listing welcoming so that it stands out
            to guests who want to stay in your area.</p>
        <hr>
        <form class="form">
            <fieldset>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="name">Property Name</label>
                            <input class="form-control" name="name" id="name" v-model="property.name"
                                   placeholder="Be clear and descriptive"/>
                        </div>
                        <div class="form-group">
                            <label for="description">Summary</label>
                            <textarea class="form-control" name="description" id="description"
                                      v-model="property.description"
                                      placeholder="Tell traveler what your listing."></textarea>
                        </div>
                    </div>
                </div>
            </fieldset>

            <next-button view="EditLocation"></next-button>
        </form>
        <br>
    </div>
</template>

<script>
    import NextButton from './nextButton.vue';
    export default{
        props: {
            property: {
                type: Object,
                twoWay: true
            }
        },
        components: {
            NextButton
        }
    }
</script>