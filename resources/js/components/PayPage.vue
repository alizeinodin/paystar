<template>
    <v-alert
        :type="data.type"
        :title="data.title"
        :text="data.msg"
    ></v-alert>
</template>

<script>
export default {
    name: "PayPage",
    data: () => ({
        data: {
            type: 'error',
            title: null,
            msg: null,
        }
    }),
    created() {
        const type = this.$route.params.t
        if (type == 'success') {
            this.data.type = 'success'
            this.data.title = "پرداخت با موفقیت انجام شد"
            this.data.msg = "مبلغ : " + this.$route.params.price + "  شماره رهگیری: " + this.$route.params.ref_num + " شماره کارت: " + this.$route.params.card_number
        } else {
            this.data.title = "عملیات با شکست مواجه شد"
            this.data.msg = "پرداخت با شکست مواجه شد. در صورت کم شدن وجه، تا 72 ساعت آینده مبلغ به حساب شما برگردانده می شود."
        }
    }

}
</script>

<style scoped>

</style>
