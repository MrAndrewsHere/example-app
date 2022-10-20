<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import FormSection from '@/Components/FormSection.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm} from "@inertiajs/inertia-vue3";

const  props = defineProps({
    sortBy:{
        type:String,
        default:null
    },
    category:{
        type:String,
        default:null
    },
    descending:{
        type:Boolean,
        default:false
    }

})
const form = useForm({
    _method: 'GET',
    category: props.category,
    sortBy: props.sortBy,
    descending:props.descending,
});

const updateProfileInformation = () => {

    form.post(route('/manager'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

</script>

<template>
    <AppLayout title="Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ads
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <FormSection>
                        <template #form>

                            <div class="row justify-content-end m-4 text-right">
                                <label class="mx-2" for="sort" >Сортировка</label>
                                <select id="sort"  name="sortBy">
                                    <option ></option>
                                    <option value="0">Время создания</option>
                                    <option value="1">Цена</option>
                                </select>
                                <select id="sort"  name="descending">
                                    <option ></option>
                                    <option value="0">По возрастанию</option>
                                    <option value="1">По убыванию</option>
                                </select>

                                <label class="mx-2" for="category" >Категория</label>
                                <select id="category" name="category">
                                    <option></option>
                                    <option v-for="(category) in this.$page.props.ads.categories" :value="category.name">
                                        {{category.name}}
                                    </option>
                                </select>

                                <SecondaryButton :class="{ 'opacity-25': form.processing ,'mx-3':''}">Клик</SecondaryButton>
                            </div>
                        </template>
                    </FormSection>


                    <div class="grid grid-flow-col auto-rows-fr auto-cols-fr  grid-rows-4">
                        <div class="m-5" v-for="item in this.$page.props.ads.data" :key="item.id">
                            <img  class="w-full aspect-video" :src="item.preview.url">
                            <br>
                            <br>
                            <span class="text-xs">{{item.name}}</span>
                            <br>
                            <br>
                            <span class="text-xs font-weight-bold">{{item.price}} руб.</span>
                        </div>
                    </div>

                    <Pagination class="mt-6" :links="this.$page.props.ads.meta.links" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<style scoped>

</style>
