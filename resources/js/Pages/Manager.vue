<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Ads from "@/Pages/Ads/Index.vue";
import {InertiaLink} from "@inertiajs/inertia-vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    ads:Object
})
const create = ()=> {route('ads.create')}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Объявления
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <ads :ads="ads">
                        <template v-slot:name="{item}">
                            <InertiaLink  class="text-blue-400 text-sm p-3 font-semibold" :href="route('ads.edit',item.id)" >
                                {{item.name}}
                            </InertiaLink>
                        </template>

                        <template #create>

                            <a  :href="route('ads.create')" class=" inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm" >
                                Создать
                            </a>
                        </template>
                    </ads>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>

</style>
