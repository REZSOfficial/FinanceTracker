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
    payment: {
        type: Object,
        default: null,
    },
    type: {
        type: String,
        default: null,
    },
});

const iconMap = {
    food_drink: {
        icon: faBurger,
        class: "text-orange-600 bg-slate-700 shadow-lg shadow-slate-700/50 border-2 border-slate-600",
    },
    transportation: {
        icon: faCar,
        class: "text-black bg-yellow-600 shadow-lg shadow-yellow-600/50 border-2 border-yellow-500",
    },
    housing: {
        icon: faHouse,
        class: "text-slate-600 bg-red-300 py-[0.8rem] shadow-lg shadow-red-300/50 border-2 border-red-400",
    },
    healthcare: {
        icon: faNotesMedical,
        class: "text-white bg-red-700 shadow-lg shadow-red-700/50 border-2 border-red-600",
    },
    entertainment: {
        icon: faGift,
        class: "bg-indigo-700 shadow-lg shadow-indigo-700/50 border-2 border-indigo-600",
    },
    other: {
        icon: faWandMagic,
        class: "bg-purple-900 shadow-lg shadow-purple-900/50 border-2 border-purple-600",
    },
};
</script>

<template>
    <FontAwesomeIcon
        v-if="payment && iconMap[payment.type]"
        class="p-3 my-auto text-2xl rounded-xl h-[1.5rem] w-[1.5rem]"
        :icon="iconMap[payment.type].icon"
        :class="iconMap[payment.type].class"
    />
    <FontAwesomeIcon
        v-if="type && iconMap[type]"
        class="p-3 my-auto text-2xl rounded-xl h-[1.5rem] w-[1.5rem]"
        :icon="iconMap[type].icon"
        :class="iconMap[type].class"
    />
</template>
