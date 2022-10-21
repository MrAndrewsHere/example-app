<script setup xmlns="http://www.w3.org/1999/html">
import AppLayout from '@/Layouts/AppLayout.vue';
import {useForm} from "@inertiajs/inertia-vue3";
import InputLabel from "@/Components/InputLabel.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";


const props = defineProps({
    categories:Array,
    errors:Object
})
const ad = {
    category: undefined,
    name: undefined,
    description: undefined,
    price: undefined,
}
const form = useForm({
    category: ad.category,
    name: ad.name,
    description: ad.description,
    price: ad.price,
});

const create = ()=>{
    form.post(route('ads.store'),{
        preserveScroll: true,
    })
}


</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Новое объявление
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">

                    <span class="m-6">

                    <a class="text-blue-500 " :href="route('manager')">К списку</a>
                    </span>

                    <form @submit.prevent="create">
                        <div class="m-7">
                            <InputLabel for="nameInput" value="Название"></InputLabel>
                            <input  v-model="form.name"/>
                            <InputError :message="errors.name"></InputError>
                        </div>

                        <div class="m-7">
                            <InputLabel for="categoryInput" value="Категория"></InputLabel>
                            <select v-model="form.category">
                                <option v-for="category in props.categories" :key="category.id">
                                    {{category.name}}
                                </option>
                            </select>
                            <InputError :message="errors.category"></InputError>
                        </div>

                        <div class="m-7">
                            <InputLabel for="descInput" value="Описание"></InputLabel>
                            <textarea id="descInput" v-model="form.description"></textarea>
                            <InputError :message="errors.description"></InputError>
                        </div>

                        <div class="m-7">
                            <InputLabel for="priceInput" value="Стоимость (руб.)"></InputLabel>
                            <input id="priceInput"  v-model="form.price"/>
                            <InputError :message="errors.price"></InputError>
                        </div>



                        <div class="m-7">
                            <SecondaryButton type="submit">Создать</SecondaryButton>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
