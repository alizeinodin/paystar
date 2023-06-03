<template>
    <v-container>
        <v-row no-gutters>
            <v-col
                v-for="n in 1"
                :key="n"
                cols="12"
                sm="4"
            >
                <Product title="test" price="2000" body="test hello"></Product>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import Product from './Product.vue'

export default {
    name: "Home",
    setup() {
        axios({
            method: 'get',
            url: 'https://kiwi.ssceb.ir/api/product/all',
            timeout: 20000,
            headers: {
                'Accept': 'application/json',
            }

        })
            .then(function (response) {
                console.log(response)
            })
            .catch(function (response) {
                console.log(response)
            })
    },
    components: {
        Product
    }
}
</script>

<style scoped>

</style>
