<template>
    <div class="flex flex-row items-center text-right mx-4 mb-4">
        <img id="weather_icon" class="h-44 stroke-1" alt="Weather icon" src='https://openweathermap.org/img/wn/01d@2x.png' />
        <div class="leading-7 tracking-tight w-full">
            <p id="city_name" class="text-2xl italic mb-1">City</p>
            <p>
                Current :  <span id="current">23</span>ºC
            </p>
            <p>
                Feels like :  <span id="feel">22</span>ºC
            </p>
        </div>
    </div>
    <CityChanger ></CityChanger>
</template>

<script>

import {mapActions, mapMutations} from "vuex";
import CityChanger from '../components/CityChanger.vue';

export default {

    name: "Home",
    components:{
        CityChanger
    },

    /*
     *  I am not able to use beforeCreated to more smoothly represent the data change
     *  since if I do use beforeCreate methods won't be loaded, and I cannot use load()
     */
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
            } else{
                this.displayData(response);
            }
        })

    },
    methods:{
        ...mapActions({
            load: 'getUserCity',
            choose: 'chooseCity',   // For getting new weather when user chooses a new city
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
                        this.displayData(response);
                    }
                });

            } else{
                this.$notify({
                    title: "<i>Empty input</i>",
                    text: 'Please enter a <b>City</b> first, to search!',
                    type:'error'
                });
            }
        },
        displayData(data){
            document.getElementById('weather_icon').src = "https://openweathermap.org/img/wn/"+data.icon+"@2x.png"
            document.getElementById('city_name').innerHTML = data.name;
            document.getElementById('current').innerHTML = Math.round(data.current);
            document.getElementById('feel').innerHTML = Math.round(data.feels);
        }
    },
}
</script>
