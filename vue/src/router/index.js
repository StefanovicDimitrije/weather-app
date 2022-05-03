import {createRouter, createWebHistory} from "vue-router";
import store from "../store";   // Vuex store used to check on the user state

import Wrapper from "../components/Wrapper.vue";

import GuestLayout from "../components/GuestLayout.vue";
import UserLayout from "../components/UserLayout.vue";

import Landing from "../views/Landing.vue";
import Login from "../views/Login.vue";
import LoginGoogle from "../views/LoginGoogle.vue"
import Home from "../views/Home.vue";
import TwelveHours from "../views/TwelveHours.vue";

const routes = [
    {
        path: '/',
        redirect: '/guest',
        name: 'Root',
        component: Wrapper,
        children: [
            {
                path: '/user',
                redirect:'/home',
                name: 'User',
                component: UserLayout,
                meta: {requiresUser: true},
                children:[
                    {
                        path: '/home',
                        name: 'Home',
                        component: Home
                    },
                    {
                        path: '/more',
                        name: 'Twelve Hour Weather',
                        component: TwelveHours
                    }
                ]
            },
            {
                path: '/guest',
                redirect: '/landing',
                name: 'Guest',
                component: GuestLayout,
                meta: {requiresGuest: true},
                children:[
                    {
                        path: '/landing',
                        name: 'Landing',
                        component: Landing
                    },
                    {
                        path: '/login',
                        name: 'Login',
                        component: Login
                    },
                    {
                        path: '/google/callback',
                        name: 'Login with Google',
                        component: LoginGoogle
                    },
                ]
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next)=>{

    //console.log(store.state.user.token);
    //console.log(localStorage.getItem('TOKEN'))

    /*
     * The token, when it actually exists, doesn't work with json.parse, but
     * since we are storing the token in local storage, when the token is null
     * the token will be the string of the word "null"
     *
     * So the options are either to json.parse the "null" into null
     *      Which we cannot since the token doesn't go through the parser
     * Or to check if the token is the string equivalent of the word "null"
     *      In which case we must also say, on the logout, the vuex state for the token
     *      must be the string "null" (check mutation logout)
     */

    if(to.meta.requiresUser && (store.state.user.token === 'null')){
        console.log('Redirecting back to login')
        next({name:'Login'})
    } else if (to.meta.requiresGuest && (store.state.user.token !== 'null') && !(to.name === 'Login with Google')) {
        console.log('Redirecting back to the homepage')
        next({name:'Home'});
    } else {
        console.log('ok')
        next();
    }
})

export default router;
