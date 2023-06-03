<template>
    <v-card
        class="mx-auto"
        max-width="344"
    >
        <v-img
            src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
            height="200px"
            cover
        ></v-img>

        <v-card-title>
            {{ title }}
        </v-card-title>

        <v-card-subtitle>
            قیمت: {{ price }}
        </v-card-subtitle>

        <v-card-actions>
            <v-btn
                color="orange-lighten-2"
                variant="text"
                @click="submit()"
            >
                خرید
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn
                :icon="show ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                @click="show = !show"
            ></v-btn>
        </v-card-actions>

        <v-expand-transition>
            <div v-show="show">
                <v-divider></v-divider>

                <v-card-text>
                    {{ body }}
                </v-card-text>
            </div>
        </v-expand-transition>
    </v-card>
</template>
<script>
export default {
    name: "Product",
    data: () => ({
        show: false
    }),
    props: ['id', 'title', 'body', 'price'],
    methods: {
        submit() {
            this.checkUser()
            this.$router.push({
                path: '/' + this.id + '/card',
            })
        },
        checkUser() {
            if (!localStorage.getItem('token')) {
                alert("Please Register or Login first.")
            }
            axios({
                method: 'get',
                url: 'https://kiwi.ssceb.ir/auth/user',
                timeout: 20000,
                headers: {
                    'Accept': 'application/json',
                }
            }).then((response) => {
                if (response.status != 200) {
                    alert("Please Register or Login first.")
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
