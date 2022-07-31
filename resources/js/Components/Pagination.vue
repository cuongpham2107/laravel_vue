<template>
    <div class="flex">
        <template v-for="(link, key) in links" :key="key">
            <div class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded bg-white"
                v-if="link.url === null" v-html="link.label"></div>
            <Link class="mb-1 mr-1 px-4 py-3 text-sm leading-4 border rounded bg-white
                                        focus:text-indigo-500 focus:border-indigo-500 hover:bg-white"
                :class="{ 'bg-indigo-200': link.active }" v-else :href="link.url" v-html="link.label">
            </Link>
        </template>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import { defineProps } from "vue";
defineProps({
    links : Array,
})
</script>
<style>
</style>