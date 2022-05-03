<template>
    <div class="flex flex-col">
        <p class="text-3xl tracking-tight text-center" id="city">
            Maribor
        </p>

        <div class="relative overflow-y-auto rounded-lg border my-5 h-96 scrollbar-hide">
            <table class="w-full text-sm text-left text-gray-400 ">
                <thead class="text-xs uppercase border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Hour from now
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Temp
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Feels like
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr class="border-b hover:bg-neutral-800"
                    v-for="hour in forecast"
                    :key="hour.hour_from"
                >
                    <th scope="row" class="px-6 py-4 font-medium text-gray-200 whitespace-nowrap">
                        {{hour.hour_from}}
                    </th>
                    <td class="px-6 py-4">
                        {{hour.current}}
                    </td>
                    <td class="px-6 py-4">
                        {{hour.feels}}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>


        <CityChanger></CityChanger>

    </div>
</template>

<script>

import CityChanger from '../components/CityChanger.vue';
import {mapActions, mapMutations, mapState} from "vuex";

export default {
    name: "TwelveHours",
    components:{
        CityChanger
    },
    computed:{
      ...mapState(['forecast'])
    },
    methods: {
        ...mapActions({
            load: 'getUserForecast',
            choose:'chooseCityForecast'
        }),
        ...mapMutations([
            'setCity',
            'setSuggestions'
        ]),
        chooseCity(){
            if(document.getElementById('search').value.length) {

                this.$notify({
                    title: "<i>Searching..</i>",
                    type:'success'
                });

                this.setCity(document.getElementById('search').value);
                this.setSuggestions([]);

                this.choose().then((response)=> {
                    if (response === 'bad_city'){
                        this.$notify({
                            title: "<i>No such city</i>",
                            text: 'The city you entered is not in our database, please try again',
                            type:'error'
                        });
                    } else if (response === 'bad_user'){
                        this.$notify({
                            title: "<i>User error</i>",
                            text: 'Please try logging in again',
                            type:'error'
                        });
                    } else{
                        console.log(response)
                        document.getElementById('city').innerHTML = response.data[0].city;
                    }
                });

            } else{
                this.$notify({
                    title: "<i>Empty input</i>",
                    text: 'Please enter a <b>City</b> first, to search!',
                    type:'error'
                });
            }
        }
    },
    created() {
        this.$notify({
            title: "<i>Loading in data..</i>",
            type:  'success'
        });
        this.load().then((response)=>{
            if (response === 'bad_user'){
                this.$notify({
                    title: "<i>User error</i>",
                    text: 'Please try logging in again',
                    type:'error'
                });
            } else {
                document.getElementById('city').innerHTML = response.data[0].city;
            }
        })
    }
}
</script>
