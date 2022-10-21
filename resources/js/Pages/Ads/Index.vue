<script setup>

import {useForm} from "@inertiajs/inertia-vue3";
import Pagination from "@/Components/Pagination.vue";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    ads: Object
})

const form = useForm({
    _method: 'GET',
    category: props.ads.category,
    sortBy: props.ads.sortBy,
    descending: props.ads.descending,
    created_at: props.ads.created_at,
});
const submit = () => {
    form.get(document.location.pathname, {
        preserveScroll: true,
    });
};

const reset = () => {
    form.descending = 1,
        form.sortBy = 'created_at',
        form.category = undefined
    submit()
}
</script>

<template>
    <div class="m-5">
    <form @submit.prevent="submit">
        <div class="row justify-content-end mb-6 ">

            <label class="mx-2 text-sm" for="sort">Сортировка</label>
            <select id="sort" class="text-sm" v-model="form.sortBy">
                <option value="created_at">Время создания</option>
                <option value="price">Цена</option>
            </select>
            <select id="sort" class="mx-2 text-sm" v-model="form.descending">
                <option :value="0">По возрастанию</option>
                <option :value="1">По убыванию</option>
            </select>

            <label class="mx-3 text-sm" for="category">Категория</label>
            <select id="category" class="text-sm" v-model="form.category">
                <option :value="null"></option>
                <option v-for="(category) in $page.props.ads.categories" :value="category.name">
                    {{ category.name }}
                </option>
            </select>
            <PrimaryButton
                type="submit"
                :class="{ 'opacity-25': form.processing ,'ml-4':true}" :disabled="form.processing">
                Принять
            </PrimaryButton>

            <DangerButton :class="['mx-1']" type="button" @click="reset"> Reset</DangerButton>
            <slot name="create"></slot>

        </div>
    </form>

    <div class="text-xs mx-6">
        Всего: {{$page.props.ads.meta.total}}
    </div>
    <div class="grid grid-cols-3 ">
        <div class="p-4" v-for="item in $page.props.ads.data" :key="item.id">
            <img class="w-full aspect-video p-3" v-if="item.preview" :src="item.preview && item.preview.url">
            <slot name="name" :item="item">
                <span class="text-sm p-3 py-1 font-bold">{{ item.name }}</span>
            </slot>


            <slot name="category" :category="item.category">
                <div class="p-3 py-0 ">
                <span class="text-xs ">Категория: {{ item.category.name }}</span>

                </div>
            </slot>
            <div class="p-3 pt-1">
                <span class="text-xs" style="color: rgba(0,0,0,0.6)"> {{ item.created_at }}</span>

            </div>

            <div class="p-3 ">
                <span class="text-xs  ">
                    Стоимость
                    <span class="italic font-semibold underline">{{ item.price }} руб.</span>
                </span>
            </div>
        </div>
    </div>

    <pagination class="mt-6" :links="$page.props.ads.meta.links"/>
    </div>
</template>


<style scoped>

</style>
