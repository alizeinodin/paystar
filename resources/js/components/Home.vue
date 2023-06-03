<template>
    <v-container>
        <v-row no-gutters>
            <v-col
                v-for="(item, index) in products"
                :key="index"
                cols="12"
                sm="4"
            >
                <Product :id="item.id" :title="item.title" :price="item.price" :body="item.body"></Product>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Product from './Product.vue'

export default {
    name: "Home",
    created() {
        this.getProducts()
    },
    components: {
        Product
    },
    data() {
        return {
            products: []
        }
    },
    methods: {
        getProducts() {
            axios({
                method: 'get',
                url: 'https://kiwi.ssceb.ir/api/product/all',
                timeout: 20000,
                headers: {
                    'Accept': 'application/json',
                }

            })
                .then((response) => {
                    console.log(response)
                    this.products = response.data
                })
                .catch((response) => {
                    console.log(response)
                })
        }
    }
}
</script>

<style scoped>

</style>
