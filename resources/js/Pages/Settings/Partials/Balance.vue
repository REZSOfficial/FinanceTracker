<script setup>
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ActionMessage from "@/Components/ActionMessage.vue";

const balanceForm = useForm({
    balance: 0,
});
</script>

<template>
    <form
        class="flex flex-col w-5/6 mx-auto gap-y-6"
        @submit.prevent="balanceForm.post(route('balance.update'))"
    >
        <div class="flex flex-col sm:flex-row gap-x-2">
            <p
                class="p-2 px-[1.1rem] text-center my-auto text-4xl text-white bg-green-600 rounded-full"
            >
                $
            </p>
            <div class="w-full">
                <label for="balance">Your Balance</label>
                <div class="flex gap-x-2">
                    <input
                        id="balance"
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        name="balance"
                        v-model="balanceForm.balance"
                    />
                    <p class="mt-auto text-4xl text-green-600">$</p>
                </div>
            </div>
        </div>

        <div class="flex flex-row my-auto">
            <ActionMessage
                class="w-4/6 my-auto text-center"
                :on="balanceForm.recentlySuccessful"
                >Saved.</ActionMessage
            >
            <PrimaryButton
                type="submit"
                class="w-4/6 bg-green-600 sm:w-2/6 hover:bg-green-700"
                >Save</PrimaryButton
            >
        </div>
    </form>
</template>
