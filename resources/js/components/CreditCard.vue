<template>
    <v-card variant="tonal" prepend-icon="mdi-credit-card-check">
        <template v-slot:title>
            {{ card_number }}
        </template>
        <v-card-actions>
            <v-btn @click="selectCard()">انتخاب کنید</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: "CreditCard",
    props: ['card_number', 'id', 'product_id'],
    data: () => ({
        data: {}
    }),
    methods: {
        selectCard() {
            const token = localStorage.getItem('token')

            axios({
                method: 'post',
                url: "https://kiwi.ssceb.ir/api/order/buy/" + this.product_id,
                timeout: 20000,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    card_id: this.id
                }
            }).then((response) => {
                console.log(response)
                this.data = response.data
                this.$emit('GoToBank', this.data)
            }).catch((response) => {
                console.log(response)
            })
        }
    }
}
</script>

<style scoped>

</style>
