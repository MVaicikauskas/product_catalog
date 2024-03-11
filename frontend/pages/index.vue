<template>
    <section id="page-index">
        <div class="container-xl px-4 my-3">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    {{ 'filters' }}
                </div>
                <div class="card-body">
                    <div class="col-12 mb-1">
                        <NuxtLink  class="btn btn-primary" :to="'/product-create'">{{ 'Add product' }}</NuxtLink>
                    </div>
                    <TableComponent :data="items"/>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import TableComponent from "~/components/tableComponent/TableComponent.vue";
import { IBrand } from "~/interfaces/IBrand.interface";
import { ICategory } from "~/interfaces/ICategory.interface";
import { IProduct } from "~/interfaces/IProduct.interface";

export default {
    name: "index",
    components: {TableComponent},
    data() {
        return {
            mainData: {
                categories: <ICategory[]>[],
                brands: <IBrand[]>[],
            },
            items: <IProduct[]>[],
        }
    },
    mounted() {
        this.getMainData();
    },
    methods: {
        /**
         * @return void
         */
        async getMainData(): void {
            const runTime = useRuntimeConfig();
            const responseData = await $fetch(runTime.public.apiBase + '/product/main-data');

            this.mainData.categories = <ICategory>responseData.categories;
            this.mainData.brands = <IBrand>responseData.brands;
            this.items = <IProduct>responseData.products;
        },
    },
}
</script>

<style scoped>

</style>