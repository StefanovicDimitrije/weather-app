<div align="center">
<img src="https://img.icons8.com/ios-filled/100/000000/flash-on.png"/>
</div>

# Weather Lite

Laravel and Vue 3 app using OpenWeather API to show the temperature of cities in Slovenia

## Installation

Clone the repository and cd into the repo folder

Install the dependencies using [Composer](http://getcomposer.org/)

    composer install

You are also going to require your own .env file

Run the database migrations

    php artisan migrate

Be sure to set up database connection in the .env file,
and have a connection to the internet so that OpenWeather data can be fetched

### Setup the Vue app

Switch to the vue folder with cd and run

    npm install

Then, run the local development server

    npm run dev

### Lastly

Run the laravel back-end local development server

    php artisan serve

Initiate the laravel scheduler, so the data is updated locally

    php artisan schedule:work

# App details

The app uses laravel for the back-end including:

1. Socialite - For social login
2. Scheduler - For hourly updates

The front-end is built using Vue 3 and Vite including:

1. Tailwindcss - For styling pages and components
2. Vuex - For global states and actions
3. Vue router
4. Axios - For http requests to the back-end

There is also a notifications plugin for Vue from [kyvg](https://github.com/kyvg)

# Functionalities

The app enables social login via Google to save the user's chosen preferences. 
It can display the current weather and a table for the representation for the next 12 hours.

The user can always update the chosen city, via the search bar at the bottom, from the available citites.
