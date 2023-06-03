<template>
    <v-card variant="tonal" prepend-icon="mdi-credit-card-check">
        <template v-slot:title>
            {{ card_number }}
        </template>
        <v-card-actions>
            <v-btn>انتخاب کنید</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: "CreditCard",
    props: ['card_number']
}
</script>

<style scoped>

</style>
