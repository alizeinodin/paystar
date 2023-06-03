<template>

    <v-layout class="overflow-visible" style="height: 56px;">
        <v-bottom-navigation
            v-model="value"
            mode="shift"
            color="teal"
            grow
        >
            <router-link to="/">
                <v-btn>
                    <v-icon>mdi-home-minus-outline</v-icon>
                    <span>خانه</span>
                </v-btn>
            </router-link>

            <router-link to="/register">
                <v-btn>
                    <v-icon>mdi-account-plus-outline</v-icon>
                    <span>ثبت نام</span>
                </v-btn>
            </router-link>

            <router-link to="/login">
                <v-btn>
                    <v-icon>mdi-login-variant</v-icon>
                    <span>ورود</span>
                </v-btn>
            </router-link>

        </v-bottom-navigation>
    </v-layout>
</template>

<script>
export default {
    name: "Navbar",
    data: () => ({
        value: 0
    }),
}
</script>
<style scoped>

</style>
