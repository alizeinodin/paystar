<template>

    <v-layout class="overflow-visible" style="height: 56px;">
        <v-bottom-navigation
            v-model="value"
            mode="shift"
            color="teal"
            grow
        >

            <v-btn>
                <router-link to="/">
                    <v-icon>mdi-home-minus-outline</v-icon>

                    <span>Home</span>
                </router-link>
            </v-btn>

            <v-btn>
                <v-icon>mdi-account-plus-outline</v-icon>

                <span>Register</span>
            </v-btn>

            <v-btn>
                <v-icon>mdi-login-variant</v-icon>

                <span>Login</span>
            </v-btn>
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
