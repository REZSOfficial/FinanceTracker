<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    href: String,
    as: String,
});
</script>

<template>
    <div>
        <button
            v-if="as == 'button'"
            type="submit"
            class="block w-full px-4 py-2 text-sm leading-5 transition duration-150 ease-in-out text-lighter text-start hover:bg-light focus:outline-none"
        >
            <slot />
        </button>

        <a
            v-else-if="as == 'a'"
            :href="href"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none"
        >
            <slot />
        </a>

        <Link
            v-else
            :href="href"
            class="block px-4 py-2 leading-5 transition duration-150 ease-in-out text-lighter text-md hover:bg-light focus:outline-none"
        >
            <slot />
        </Link>
    </div>
</template>
