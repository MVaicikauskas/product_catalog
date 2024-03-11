<template>
    <table class="table table-hover border">
        <thead>
        <tr>
            <th class="border-end"></th>
            <th class="border-end">{{ 'Item title' }}</th>
            <th class="border-end">{{ 'Price' }}</th>
            <th class="border-end">{{ 'Stock' }}</th>
            <th class="border-end">{{ 'Condition' }}</th>
            <th class="border-end">{{ 'Model' }}</th>
            <th class="border-end">{{ 'Brand name' }}</th>
            <th class="border-end">{{ 'Category title' }}</th>
            <th class="border-end">{{ 'Delivery price' }}</th>
            <th class="border-end">{{ 'Delivery time' }}</th>
            <th>{{ 'Link' }}</th>
        </tr>
        </thead>
        <tbody>
        <template v-if="data.length">
            <template v-for="item in data" :key="item.id">
                <tr>
                    <td class="border-end"><img :src="item.image_url" class="img-thumbnail" :alt="item.title"></td>
                    <td class="border-end">{{ item.title }}</td>
                    <td class="border-end">{{ item.price }}</td>
                    <td class="border-end">{{ item.stock }}</td>
                    <td class="border-end">{{ item.condition }}</td>
                    <td class="border-end">{{ item.model }}</td>
                    <td class="border-end">{{ item.brand_name }}</td>
                    <td class="border-end">{{ item.category_title }}</td>
                    <td class="border-end">{{ item.delivery_price }}</td>
                    <td class="border-end">{{ item.delivery_time }}</td>
                    <td><a :href="item.product_url" class="text-decoration-none">{{ 'Link' }}</a></td>
                </tr>
            </template>
        </template>
        <template v-else>
            <tr>
                <td colspan="5">{{ 'According to selected filters there is no matched items or there none of them at all.' }}</td>
            </tr>
        </template>
        </tbody>
    </table>
</template>

<script lang="ts">
export default {
    name: "TableComponent",
    props: {
        data: {
            type: Array,
            default: [],
        }
    }
}
</script>

<style scoped>

</style>