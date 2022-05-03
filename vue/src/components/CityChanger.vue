<template>
    <div class="flex">
        <input id="search" type="text" autocomplete="off" class="w-2/3 bg-neutral-900 p-1" placeholder="Search for a city" @input="searchInput">
        <div id="searchButton" class="w-1/3 p-1 flex justify-center cursor-pointer" @click="chooseCity"> <map-search-icon :size="30"/> </div>
    </div>
    <ul class="w-2/3 border-b relative">
        <li
            v-for="city in suggestions"
            :key="city.name"
            class="p-1 cursor-pointer border-t"
            @click="selectCity(city.name)"
        >
            {{ city.name }}
        </li>
    </ul>
</template>

<script>

import {mapActions, mapMutations, mapState} from "vuex";
import MapSearchIcon from "vue-material-design-icons/MapSearch.vue";

export default {
    name: "CityChanger",
    components:{
        MapSearchIcon
    },
    computed:{
        ...mapState(['suggestions'])
    },
    methods:{
        ...mapActions({
            search: 'searchCity',   // For the suggestions
            choose: 'chooseCity',   // For getting new weather when user chooses a new city
        }),
        ...mapMutations([
            'setCity',
            'setSuggestions'
        ]),
        selectCity(city){       // When one of the suggestions is pressed
            document.getElementById('search').value = city;
            this.setSuggestions([])
        },
        searchInput(){          // When input is detected in the search field
            if(document.getElementById('search').value.length) {
                this.setCity(document.getElementById('search').value);
                this.search();
            } else {
                this.setSuggestions([])
            }
        },
        chooseCity(){           // When the search button is finally pressed and user chooses the city
            this.$parent.chooseCity();
        },
    }
}
</script>
