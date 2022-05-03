<template>
    <div id="contentwrapper" class="flex flex-col m-0 p-0 min-h-screen bg-neutral-900 text-gray-100">
        <Header></Header>
        <router-view></router-view>
    </div>
</template>

<script>

import Header from "./Header.vue";

export default {
    components:{
        Header
    },
    name: "Wrapper"
}
</script>

<style scoped>

</style>
