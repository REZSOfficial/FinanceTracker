<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Payments from "@/Pages/Payments/Partials/Payments.vue";

const props = defineProps({
    outgoings: Object,
    incomings: Object,
});
</script>
<template>
    <AppLayout title="Payments">
        <div class="flex flex-col w-3/4 gap-4 mx-auto mt-12 md:flex-row">
            <div class="w-full">
                <Payments :type="'outgoing'" :payments="outgoings"></Payments>
            </div>
            <div class="w-full">
                <Payments :type="'incoming'" :payments="incomings"></Payments>
            </div>
        </div>
    </AppLayout>
</template>
