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
    payment: Object,
});

const iconMap = {
    food_drink: { icon: faBurger, class: "text-orange-600 bg-slate-700" },
    transportation: { icon: faCar, class: "text-black bg-yellow-600" },
    housing: { icon: faHouse, class: "text-slate-600 bg-red-300 py-[0.8rem]" },
    healthcare: { icon: faNotesMedical, class: "text-white bg-red-700" },
    entertainment: { icon: faGift, class: "bg-indigo-700" },
    other: { icon: faWandMagic, class: "bg-purple-900" },
};
</script>

<template>
    <FontAwesomeIcon
        v-if="iconMap[payment.type]"
        class="p-3 my-auto text-2xl rounded-full"
        :icon="iconMap[payment.type].icon"
        :class="iconMap[payment.type].class"
    />
</template>
