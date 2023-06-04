<template>
    <v-container v-if="checkCards()">
        <span>هیچ کارتی در لیست شما موجود نمی باشد.</span>
    </v-container>
    <v-container v-else>
        <v-row no-gutters>
            <v-col
                v-for="(item, index) in cards"
                :key="index"
                cols="12"
                sm="4"
            >
                <CreditCard :id="item.id" :card_number="item.card_number" :product_id="product_id"
                            @GoToBank="openPay($event)"></CreditCard>
            </v-col>
        </v-row>
    </v-container>

    <v-divider></v-divider>

    <v-row justify="center">
        <v-dialog
            v-model="dialog"
            persistent
            width="1024"
        >
            <template v-slot:activator="{ props }">
                <v-btn
                    prepend-icon="mdi-plus"
                    color="teal"
                    v-bind="props"
                >
                    افزودن کارت
                </v-btn>
            </template>
            <v-card>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="شماره کارت*"
                                    v-model="card_number"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        بیخیال!
                    </v-btn>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="addCard()"
                    >
                        افزودن
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>

    <!--   pay diolog -->
    <v-col cols="auto">
        <v-dialog v-model="isActive"
                  transition="dialog-bottom-transition"
                  width="auto"
        >
            <template v-slot:default="{ isActive }">
                <v-card>
                    <v-toolbar
                        color="primary"
                    ></v-toolbar>
                    <v-card-text>
                        <div>مبلغ نهایی: {{ amount }}</div>
                    </v-card-text>
                    <v-card-actions class="justify-center">
                        <form action="https://core.paystar.ir/api/pardakht/payment" method="POST">
                            <input type="hidden" name="token" :value="token">
                            <input
                                type="submit"
                                class="btn-warning"
                                value="پرداخت"
                            >
                        </form>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </v-col>


</template>

<script>
import CreditCard from './CreditCard.vue'

export default {
    name: "CardPage",
    components: {
        CreditCard
    },
    created() {
        this.product_id = this.$route.params.id
        console.log(this.product_id)
        this.getCards()

    },
    data: () => ({
        cards: [],
        product_id: null,
        dialog: false,
        card_number: null,
        isActive: false,
        amount: null,
        token: null,
        redirect: false,
        responseData: null
    }),

    methods: {
        getCards() {
            const token = localStorage.getItem('token')

            axios({
                method: 'get',
                url: 'https://kiwi.ssceb.ir/api/card/all',
                timeout: 20000,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                }
            }).then((response) => {
                if (response.status === 200) {
                    this.cards = response.data
                }
                console.log(response)
            }).catch((response) => {
                alert("Error")
                console.log(response)
            })
        },
        checkCards() {
            return this.cards.length === 0
        },
        addCard() {
            const token = localStorage.getItem('token')

            axios({
                method: 'post',
                url: 'https://kiwi.ssceb.ir/api/card/store',
                timeout: 20000,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + token
                },
                data: {
                    card_number: this.card_number
                }
            }).then((response) => {
                console.log("ok", response)
            }).catch((response) => {
                alert("Error")
                console.log(response)
            })

            this.dialog = false

            this.getCards()
            console.log(this.cards)

        },
        openPay(data) {
            this.amount = data.amount
            this.token = data.token
            this.isActive = true
        }
        ,
        redirectToBank() {
            console.log(this.token, this.amount)

            axios({
                method: 'post',
                url: 'https://core.paystar.ir/api/pardakht/payment',
                timeout: 20000,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                data: {
                    token: this.token
                }
            }).then((response) => {
                window.location.href = 'https://core.paystar.ir/api/pardakht/payment'
            }).catch((response) => {
                console.log(response)
                alert("ERROR from bank")
            })
        }
    }
}
</script>

<style scoped>
* {
    font-family: IRANSans;
}

@font-face {
    font-family: IRANSans;
    font-weight: normal;
    src: url("./fonts/eot/IRANSansWeb.eot") format("embedded-opentype"),
    url("./fonts/ttf/IRANSansWeb.ttf") format("truetype"),
    url("./fonts/woff/IRANSansWeb.woff") format("woff");
}
</style>
