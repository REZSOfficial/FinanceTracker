<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import {
    faUser,
    faPlus,
    faMinus,
    faBullseye,
} from "@fortawesome/free-solid-svg-icons";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AddIncoming from "@/Components/AddIncoming.vue";
import AddOutgoing from "@/Components/AddOutgoing.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const showCreateIncoming = ref(false);
const showCreateOutgoing = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <div class="min-h-screen" id="app-container">
            <nav>
                <!-- Primary Navigation Menu -->
                <div class="px-4 max-w-7xl sm:px-0 lg:px-2">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex items-center shrink-0">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="items-center hidden space-x-4 sm:ms-10 md:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                                <NavLink
                                    :href="route('payments')"
                                    :active="route().current('payments')"
                                >
                                    Payments
                                </NavLink>
                                <NavLink
                                    :href="route('viewGoals')"
                                    :active="route().current('viewGoals')"
                                >
                                    Goals
                                </NavLink>
                                <NavLink
                                    :href="route('averages.index')"
                                    :active="route().current('averages.index')"
                                >
                                    Average
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden md:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button
                                            v-if="
                                                $page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                            class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300"
                                        >
                                            <img
                                                class="object-cover w-8 h-8 rounded-full"
                                                :src="
                                                    $page.props.auth.user
                                                        .profile_photo_url
                                                "
                                                :alt="
                                                    $page.props.auth.user.name
                                                "
                                            />
                                        </button>

                                        <span
                                            v-else
                                            class="inline-flex rounded-md"
                                        >
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 font-medium leading-4 transition duration-150 ease-in-out border border-transparent rounded-md text-md hover:bg-dark text-lighter focus:outline-none focus:bg-dark active:bg-dark"
                                            >
                                                <FontAwesomeIcon
                                                    class="p-2 px-3 bg-white rounded-full me-2 text-lighter"
                                                    :icon="faUser"
                                                ></FontAwesomeIcon>
                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->

                                        <DropdownLink
                                            :href="route('settings.show')"
                                        >
                                            Settings
                                        </DropdownLink>

                                        <DropdownLink
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                <span
                                                    class="font-bold text-red-600"
                                                    >Log Out</span
                                                >
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center me-2 md:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 transition duration-150 ease-in-out rounded-md text-lighter hover:text-lighter hover:bg-dark focus:outline-none focus:bg-dark focus:text-lighter"
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                            >
                                <svg
                                    class="w-6 h-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="md:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('payments')"
                            :active="route().current('payments')"
                        >
                            Payments
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('viewGoals')"
                            :active="route().current('viewGoals')"
                        >
                            Goals
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('averages.index')"
                            :active="route().current('averages.index')"
                        >
                            Average
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="shrink-0 me-3"
                            >
                                <img
                                    class="object-cover w-10 h-10 rounded-full"
                                    :src="
                                        $page.props.auth.user.profile_photo_url
                                    "
                                    :alt="$page.props.auth.user.name"
                                />
                            </div>

                            <div>
                                <div class="text-base font-medium text-blue">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('settings.show')"
                                :active="route().current('settings.show')"
                            >
                                Settings
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')"
                            >
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    <span class="font-bold text-red-600"
                                        >Log Out</span
                                    >
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template
                                v-if="$page.props.jetstream.hasTeamFeatures"
                            >
                                <div class="border-t border-gray-200" />

                                <div
                                    class="block px-4 py-2 text-xs text-gray-400"
                                >
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink
                                    :href="
                                        route(
                                            'teams.show',
                                            $page.props.auth.user.current_team
                                        )
                                    "
                                    :active="route().current('teams.show')"
                                >
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink
                                    v-if="$page.props.jetstream.canCreateTeams"
                                    :href="route('teams.create')"
                                    :active="route().current('teams.create')"
                                >
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template
                                    v-if="
                                        $page.props.auth.user.all_teams.length >
                                        1
                                    "
                                >
                                    <div class="border-t border-gray-200" />

                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Switch Teams
                                    </div>

                                    <template
                                        v-for="team in $page.props.auth.user
                                            .all_teams"
                                        :key="team.id"
                                    >
                                        <form
                                            @submit.prevent="switchToTeam(team)"
                                        >
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg
                                                        v-if="
                                                            team.id ==
                                                            $page.props.auth
                                                                .user
                                                                .current_team_id
                                                        "
                                                        class="w-5 h-5 text-green-400 me-2"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
                <div class="fixed flex flex-col p-1 right-2 bottom-2 gap-y-2">
                    <PrimaryButton
                        :icon="faPlus"
                        id="inBtn"
                        class="bg-green-600 hover:bg-green-700"
                        role="button"
                        @click="showCreateIncoming = !showCreateIncoming"
                    >
                        Add incoming
                    </PrimaryButton>
                    <PrimaryButton
                        :icon="faMinus"
                        id="outBtn"
                        class="bg-red-600 hover:bg-red-700"
                        role="button"
                        @click="showCreateOutgoing = !showCreateOutgoing"
                    >
                        Add outgoing
                    </PrimaryButton>
                    <PrimaryButton
                        :icon="faBullseye"
                        class="bg-yellow-600 hover:bg-yellow-700"
                        ><a :href="route('createGoal')"
                            >Add Goal</a
                        ></PrimaryButton
                    >
                </div>
                <AddIncoming
                    @close="showCreateIncoming = false"
                    :show="showCreateIncoming"
                ></AddIncoming>
                <AddOutgoing
                    @close="showCreateOutgoing = false"
                    :show="showCreateOutgoing"
                ></AddOutgoing>
            </main>
        </div>
    </div>
    <footer>
        <div class="h-[100px]"></div>
        <div
            class="flex flex-wrap gap-12 p-4 text-lg gap-y-4 text-blue bg-dark"
        >
            <h1>Finance Manager Application</h1>
            <h2>Copyright © 2024</h2>
            <h3>
                Built with:
                <span class="text-red-200">[Laravel / </span>
                <span class="text-red-200">Vue / </span>
                <span class="text-red-200">Inertia]</span>
            </h3>
            <h3>by: Nagy Zsombor Attila</h3>
        </div>
    </footer>
</template>
