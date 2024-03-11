<template>
    <section id="page-index">
        <div class="container-xl px-4 my-3">
            <div class="card mb-4">
                <div class="card-header d-flex">
                    {{ 'Add your product' }}
                </div>
                <div class="card-body">
                    <form>
                        <h3>{{ 'Import many products at once' }}</h3>
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <label class="small mb-1 mt-3" for="importFile">{{ 'Import file' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="importFile" type="file"
                                           accept="text/xml"
                                           v-on:change="onFileChange"
                                           :multiple="false"
                                           required autofocus/>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn mt-3 btn-primary" @click="importFile">{{ 'Import' }}</button>

                        <hr>
                        <h3>{{ "Single product's data" }}</h3>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="title">{{ 'Title' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="title" type="text" v-model="product.title" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="price">{{ 'Price' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="price" type="number" min="0.00" max="5.00" v-model="product.price" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="condition">{{ 'Condition' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="condition" type="text" v-model="product.condition" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="stock">{{ 'Stock' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="stock" type="number" v-model="product.stock" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="model">{{ 'Model' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="model" type="text" v-model="product.model" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="image_url">{{ 'Image url' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="image_url" type="text" v-model="product.image_url" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="product_url">{{ 'Product url' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="product_url" type="text" v-model="product.product_url" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="delivery_price">{{ 'Delivery price' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="name" type="number" v-model="product.delivery_price" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="delivery_time">{{ 'Delivery time' }}</label>
                                <div class="input-group">
                                    <input class="form-control" id="delivery_time" type="text" v-model="product.delivery_time" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="category">{{ 'Category' }}</label>
                                <template v-if="mainData.categories">
                                    <div class="input-group">
                                        <select class="form-control" id="category" type="text" :disabled="product.category && product.category.length" v-model="product.category_id" required>
                                            <option :value="null" selected>{{ 'Choose' }}</option>
                                            <template v-for="category in mainData.categories" :key="category.id">
                                                <option :value="category.id">{{ category.title }}</option>
                                            </template>
                                        </select>
                                    </div>
                                </template>
                                <div class="input-group" :class="{'mt-1': mainData.categories}">
                                    <input class="form-control" id="category" type="text" :disabled="product.category_id" v-model="product.category" required />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 my-1">
                                <label class="small mb-1 mt-3" for="brand">{{ 'Brand' }}</label>
                                <template v-if="mainData.brands">
                                <div class="input-group">
                                    <select class="form-control" id="brand" type="text" :disabled="product.brand && product.brand.length" v-model="product.brand_id" required>
                                        <option :value="null" selected>{{ 'Choose' }}</option>
                                        <template v-for="brand in mainData.brands" :key="brand.id">
                                            <option :value="brand.id">{{ brand.name }}</option>
                                        </template>
                                    </select>
                                </div>
                                </template>
                                <div class="input-group" :class="{'mt-1': mainData.brands}">
                                    <input class="form-control" id="brand" type="text" :disabled="product.brand_id" v-model="product.brand" required />
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn mt-3 btn-primary" @click="submit">{{ 'Save' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import type {IBrand} from "~/interfaces/IBrand.interface";
import type {ICategory} from "~/interfaces/ICategory.interface";
import type {IProduct} from "~/interfaces/IProduct.interface";

export default {
    name: "product-create",
    data() {
        return {
            import_file: {},
            product: <IProduct>{},
            mainData: {
                categories: <ICategory[]>[],
                brands: <IBrand[]>[],
            },
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
        },

        /**
         * @param {Event} e
         * @return void
         */
        onFileChange(e: Event): void {
            this.import_file = e.target.files[0];
        },

        /**
         * @return void
         */
        async importFile(): void {
            let formData = new FormData();

            formData.append('file', this.import_file);

            const runTime = useRuntimeConfig();

            const responseData = await $fetch(runTime.public.apiBase + '/product/import', {
                method: 'post',
                data: formData,
            })

            this.import_file = {};
        },

        /**
         * @return void
         */
        async submit(): void {
            const runTime = useRuntimeConfig();

            await $fetch(runTime.public.apiBase + '/products', {
                method: 'post',
                body: {product: <IProduct>this.product},
            })
        }
    },
}
</script>

<style scoped>

</style>