<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faBurger,
    faCar,
    faHouse,
    faNotesMedical,
    faGift,
    faWandMagic,
} from "@fortawesome/free-solid-svg-icons";

const props = defineProps({
    type: String,
});
</script>

<template>
    <FontAwesomeIcon
        class="p-3 my-auto text-2xl text-orange-600 rounded-full bg-slate-700"
        v-if="type === 'food_drink'"
        :icon="faBurger"
    ></FontAwesomeIcon>
    <FontAwesomeIcon
        class="p-3 my-auto text-2xl text-black bg-blue-600 rounded-full"
        v-if="type === 'transportation'"
        :icon="faCar"
    ></FontAwesomeIcon>
    <FontAwesomeIcon
        class="p-3 py-[0.8rem] my-auto text-2xl bg-red-300 rounded-full text-slate-600"
        v-if="type === 'housing'"
        :icon="faHouse"
    ></FontAwesomeIcon>
    <FontAwesomeIcon
        class="p-3 my-auto text-2xl text-white bg-red-700 rounded-full"
        v-if="type === 'healthcare'"
        :icon="faNotesMedical"
    ></FontAwesomeIcon>
    <FontAwesomeIcon
        class="p-3 my-auto text-2xl bg-blue-700 rounded-full"
        v-if="type === 'entertainment'"
        :icon="faGift"
    ></FontAwesomeIcon>
    <FontAwesomeIcon
        class="p-3 my-auto text-2xl bg-purple-900 rounded-full"
        v-if="type === 'other'"
        :icon="faWandMagic"
    ></FontAwesomeIcon>
</template>
