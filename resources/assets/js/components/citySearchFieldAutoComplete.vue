<style>
    .pac-item > span:last-child {
        display: none;
    }
</style>
<template>
    <div>
        <vue-google-autocomplete
                ref="this.address"
                name="city"
                id="map"
                classname="form-control"
                placeholder="Miejscowość"
                v-on:placechanged="getCityData"
                types="(cities)"
                country="pl"
                :value=surveyData
        >
        </vue-google-autocomplete>
    </div>
</template>

<script>
    import VueGoogleAutocomplete from 'vue-google-autocomplete'

    export default {
        components: { VueGoogleAutocomplete },

        props: ['surveyData'],

        data: function () {
            return {
                address: '',
            }
        },

        mounted() {

            this.address = this.surveyData;
            // Do something useful with the data in the template
            // console.dir(this.surveyData)

            // To demonstrate functionality of exposed component functions
            // Here we make focus on the user input
            // this.$refs.address.focus();
        },

        methods: {
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getCityData: function (addressData, placeResultData, id) {
                this.address = addressData.locality;
                // console.log(this.address);
            }
        }
    }
</script>