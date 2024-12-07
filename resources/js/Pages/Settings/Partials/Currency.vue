<script setup>
// Switch currency
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const props = defineProps({
    currency: String,
});

const form = useForm({
    currency: props.currency,
});

const updateCurrency = () => {
    form.put(route("currency.update"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <div class="flex flex-col w-5/6 mx-auto gap-y-2">
        <InputLabel for="currency">Currency</InputLabel>
        <select
            v-model="form.currency"
            @change="updateCurrency"
            id="currency"
            name="currency"
            class="w-full border-0 rounded bg-dark"
        >
            <option value="HUF">HUF</option>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="JPY">JPY</option>
            <option value="CNY">CNY</option>
        </select>
    </div>
</template>
