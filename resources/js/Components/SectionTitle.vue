<template>
    <div class="flex justify-between md:col-span-1">
        <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium text-slate-300">
                <slot name="title" />
            </h3>

            <p class="mt-1 text-gray-500 text-md">
                <slot name="description" />
            </p>
        </div>

        <div class="px-4 sm:px-0">
            <slot name="aside" />
        </div>
    </div>
</template>
