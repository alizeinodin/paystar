<template>
    <v-card class="mx-auto px-6 py-8" max-width="344">
        <v-form
            v-model="form"
            @submit.prevent="onSubmit"
        >
            <v-text-field
                v-model="email"
                :readonly="loading"
                :rules="[required]"
                class="mb-2"
                clearable
                label="Email"
            ></v-text-field>

            <v-text-field
                v-model="password"
                :readonly="loading"
                :rules="[required]"
                clearable
                label="Password"
                placeholder="Enter your password"
            ></v-text-field>

            <br>

            <v-btn
                :disabled="!form"
                :loading="loading"
                block
                color="success"
                size="large"
                type="submit"
                variant="elevated">
                Sign In
            </v-btn>
        </v-form>
    </v-card>
</template>

<script>
export default {
    name: "Login",
    data: () => ({
        form: false,
        email: null,
        password: null,
        loading: false,
    }),
    methods: {
        onSubmit() {
            if (!this.form) return

            this.loading = true

            console.log(this.email, this.password)

            setTimeout(() => (this.loading = false), 2000)
        },
        required(v) {
            return !!v || 'Field is required'
        },
    },
}
</script>

<style scoped>

</style>
