<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <main
        class="flex flex-col items-center justify-center h-screen"
        id="welcome"
    >
        <ApplicationMark class="mb-10 text-9xl"></ApplicationMark>
        <div v-if="canLogin">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="rounded-md text-xl border-b-2 border-transparent hover:border-blue duration-200 px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="rounded-md text-xl border-b-2 border-transparent hover:border-blue duration-200 px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="rounded-md text-xl border-b-2 border-transparent hover:border-blue duration-200 px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Register
                </Link>
            </template>
        </div>
    </main>
</template>
