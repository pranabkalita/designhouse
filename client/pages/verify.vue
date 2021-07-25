<template>
  <div>
    <p class="mb-4">Please verify your email before accessing that.</p>

    <form @submit.prevent="resendVerificationEmail">
      <c-button title="Resend" type="submit" :loading="loading" :disabled="loading" />
    </form>
  </div>
</template>

<script>
export default {
  middleware: ['auth'],

  data() {
    return {
      loading: false
    }
  },

  methods: {
    async resendVerificationEmail() {
      this.loading = true
      await this.$axios.post('email/verification-notification')
      this.loading = false
    }
  }
}
</script>
