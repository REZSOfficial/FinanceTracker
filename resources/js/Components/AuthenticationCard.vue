<template>
    <div
        class="flex flex-col items-center min-h-screen pt-6 sm:justify-center sm:pt-0 auth"
    >
        <div>
            <slot name="logo" />
        </div>

        <div
            class="w-full px-6 py-4 mt-6 overflow-hidden border border-gray-100/10 glass sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
