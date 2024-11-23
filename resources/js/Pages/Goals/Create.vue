<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
    title: "",
    price: "",
    date: "",
    description: "",
});
</script>

<template>
    <AppLayout title="Goals">
        <div class="py-10 mx-auto text-white max-w-7xl sm:px-6 lg:px-8">
            <form
                @submit.prevent="form.post(route('saveGoal'))"
                class="flex flex-col p-4 border rounded gap-y-6 glass"
            >
                <div>
                    <label for="title">Title</label>
                    <input
                        type="text"
                        class="w-full border-0 rounded bg-dark"
                        v-model="form.title"
                    />
                    <InputError
                        :message="form.errors.title"
                        class="text-red-500"
                    >
                    </InputError>
                </div>
                <div>
                    <label for="title">Price</label>
                    <input
                        type="number"
                        class="w-full border-0 rounded bg-dark"
                        v-model="form.price"
                    />
                    <InputError
                        :message="form.errors.price"
                        class="text-red-500"
                    >
                    </InputError>
                </div>

                <div>
                    <label for="date">Date</label>
                    <input
                        v-model="form.date"
                        class="w-full border-0 rounded bg-dark custom-date"
                        type="date"
                    />
                    <InputError
                        :message="form.errors.date"
                        class="text-red-500"
                    >
                    </InputError>
                </div>

                <div>
                    <label for="title" class="text-white">Description</label>
                    <input
                        type="text"
                        class="w-full border-0 rounded bg-dark"
                        v-model="form.description"
                    />
                </div>

                <div>
                    <PrimaryButton
                        class="w-full mt-4 bg-yellow-600 hover:bg-yellow-700"
                        >Save</PrimaryButton
                    >
                </div>
            </form>
        </div>
    </AppLayout>
</template>
