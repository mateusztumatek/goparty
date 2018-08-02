<template>
    <div>
        <div class="col-lg-auto mt-3 mb-5">
            <h3 class="text-center">KLUBY W TWOJEJ OKOLICY</h3>
        </div>

        <div class="row">

            <div v-for="club in clubs.data" class="col-12 col-md-3 mb-2">
                <div>
                    <img class="img-fluid" src="http://localhost/goparty/public/img/klub1.jpg" alt="">
                    <a :href="'clubs/' + club.id">
                        <h4 class="text-white"> {{ club.official_name}} (
                            {{ getDistanceFromLatLonInKm(position.latitude, position.longitude, club.latitude, club.longitude) }}
                             km)</h4>
                        <small>{{club.locality}}</small>
                    </a>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "nearestClubs",
        data: function () {
            return {
                position: null,
                clubs: {}
            }
        },
        mounted: function () {
            if (navigator.geolocation) {
                let self = this;

                navigator.geolocation.getCurrentPosition(function (position) {
                    self.position = position.coords;
                    let lat = self.position.latitude;
                    let long = self.position.longitude;

                    console.log(self.position.latitude);
                    console.log(self.position.longitude);



                    axios.get('/api/nearest-clubs?lat=' + lat + '&long=' + long)
                        .then(function (response) {
                            self.clubs = response;
                            // console.log(self.clubs);
                            // console.log('distance:' + self.getDistanceFromLatLonInKm(lat,long,50.667263, 17.935603899999933))
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });

            }
        },
        methods: {
            getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
                console.log('szerokosc' + lat1);
                console.log('wysokosc' + lon1);

                let R = 6371; // Radius of the earth in km
                let dLat = this.deg2rad(lat2-lat1);  // deg2rad below
                let dLon = this.deg2rad(lon2-lon1);
                let a =
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
                    Math.sin(dLon/2) * Math.sin(dLon/2)
                ;
                let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                let d = R * c; // Distance in km
                return d.toFixed(1);
            },
            deg2rad(deg) {
                return deg * (Math.PI/180)
            }
        }
    }

</script>

<style scoped>

</style>