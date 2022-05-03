import {createStore} from "vuex";
import axios from 'axios'

//JSON.parse(localStorage.getItem('USER'))||{'name':'','email':''}

const index = createStore({
    state:{
        user:{
            data:{},
            token:localStorage.getItem('TOKEN'),
        },
        city:localStorage.getItem('CITY')||'Maribor',
        suggestions:[],
        forecast:[]
    },
    getters:{
        getCity(state){
            return state.city;
        }
    },
    actions:{
        loginGoogle(){
            return new Promise((resolve,reject)=>{
                axios.get('http://localhost:8000/api/guest/google/redirect')
                    .then((response)=>{

                        if(response.data.url){
                            window.location.href = response.data.url;
                        }

                    }).catch((error)=>{
                        reject(error);
                })
            })
        },
        loginGoogleCallback(ctx, payload){
            return new Promise((resolve, reject)=>{
                axios.get('http://localhost:8000/api/guest/google/callback',{   // This route *could* be a post
                    params: payload
                }).then((response)=>{

                    if (response.data.token){
                       this.commit("login",{'user':response.data.user,'token':response.data.token});
                       resolve(response);
                   }

                }).catch((error)=>{
                    reject(error);
                })
            })
        },
        logout(){
            // Commit the mutation of logging out
            this.commit('logout');
        },
        searchCity({state}){    // Search for suggestions
            const params = encodeURIComponent(state.city);
            axios.get('http://localhost:8000/api/search/'+params)
            .then((response)=>{
                this.commit('setSuggestions',response.data)
            })
        },
        chooseCity({state}){    // Get the weather and set user chosen city

            /*
             * Encode the token, so we get only the token part
             * in the URI, and so that it is injection protected
             */
            let token = state.user.token;
            token = encodeURIComponent(token.substring( token.indexOf("|")+1 ));

            const params = encodeURIComponent(state.city);

            // Send the request to the back end that we want a new city
            return new Promise((resolve, reject)=>{
                axios.get('http://localhost:8000/api/weather/current/'+params+'/'+token)
                    .then((response)=>{

                        if(response.data.status === 'bad_city'){
                            resolve('bad_city');
                        } else if(response.data.status === 'bad_user'){
                            resolve('bad_user')
                        } else{
                            resolve(response.data.data)
                        }

                }).catch((error)=>{
                    reject(error);
                })
            })
        },
        chooseCityForecast({state}){

            let token = state.user.token;
            token = encodeURIComponent(token.substring( token.indexOf("|")+1 ));
            const params = encodeURIComponent(state.city);

            return new Promise((resolve, reject)=>{
                axios.get('http://localhost:8000/api/weather/forecast/'+params+'/'+token)
                    .then((response)=>{

                        if(response.data.status === 'bad_city'){
                            resolve('bad_city');
                        } else if(response.data.status === 'bad_user'){
                            resolve('bad_user')
                        } else{
                            this.commit('setForecast',response.data.data)
                            resolve(response.data)
                        }

                    }).catch((error)=>{
                    reject(error);
                })
            })

        },
        getUserCity(){  // Get weather for the city user last selected

            /* Since this action is preformed on the created() method
             * state is not yet defined, and we need to get the token
             * from the local storage
             */
            let token = localStorage.getItem('TOKEN');
            token = encodeURIComponent(token.substring( token.indexOf("|")+1 ));

            return new Promise((resolve, reject)=>{
                axios.get('http://localhost:8000/api/weather/current/'+token)
                    .then((response)=>{
                        if(response.data.status === 'bad_user'){
                            resolve('bad_user')
                        } else{
                            resolve(response.data.data)
                        }
                    })
                    .catch((error)=>{
                        reject(error)
                    })
            })
        },
        getUserForecast(){
            let token = localStorage.getItem('TOKEN');
            token = encodeURIComponent(token.substring( token.indexOf("|")+1 ));

            return new Promise((resolve, reject)=>{
                axios.get('http://localhost:8000/api/weather/forecast/'+token)
                    .then((response)=>{
                        if(response.data.status === 'bad_user'){
                            resolve('bad_user')
                        } else{
                            this.commit('setForecast',response.data.data)
                            resolve(response.data)
                        }
                    })
                    .catch((error)=>{
                        reject(error)
                    })
            })
        }
    },
    mutations:{
        logout:(state)=>{
            /**
             * Must be in string form so the redirect
             *  check works when you log out
             * (it redirects you to the landing page properly)
             */
            state.user.token='null';
            state.user.data={};
                //localStorage.setItem('USER',null);
            localStorage.setItem('TOKEN',null); // TODO make call to delete token in the database
        },
        login:(state,payload)=>{

            state.user.token = payload.token;
            state.user.data.name = payload.user.name;
            state.user.data.email = payload.user.email;

            state.user.data=JSON.stringify({'name':payload.user.name, 'email':payload.user.email});
            localStorage.setItem('TOKEN',payload.token);
        },
        setCity:(state,payload)=>{
            localStorage.setItem('CITY',payload);
            state.city=payload;
        },
        setSuggestions:(state,payload)=>{
            state.suggestions=payload;
        },
        setForecast:(state,payload)=>{
            state.forecast = payload;
        }
    },
    modules:{}
})

export default index;
