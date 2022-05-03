<template>
    <div class="min-h-full flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class=" max-w-md w-full flex grow gap-x-2 justify-center items-center md:w-36 lg:w-44">
        <div class="border-t border-grey-100 w-full mt-1"></div>
        <LightningBoltIcon class="h-24 stroke-1"></LightningBoltIcon>
        <div class="border-t border-grey-100 w-full mt-1"></div>
    </div>
    </div>
</template>

<script>

import {LightningBoltIcon} from '@heroicons/vue/outline'

export default {
    name: "Header",
    components:{
        LightningBoltIcon
    }
}
</script>
