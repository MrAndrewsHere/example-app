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
                Manager
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
                            <SecondaryButton  :class="['mx-3']" >
                                <InertiaLink :href="route('ads.create')" >
                                    Создать
                                </InertiaLink>
                            </SecondaryButton>
                        </template>
                    </ads>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>

</style>
