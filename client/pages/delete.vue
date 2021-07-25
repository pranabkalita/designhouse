<template>
  <div class="w-10/12 md:w-6/12 -mx-3">
    <form action="" @submit.prevent='deleteAccount' class="mb-8">
      <c-button title="Delete" type="submit" :loading="loading" :disabled="loading" />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      errors: [],
    }
  },
  methods: {
    async deleteAccount(){
      try {
        this.loading = true

        await this.$axios.delete('api/user')
        await this.$auth.logout()

        this.$router.replace({ name: 'index' })
        this.loading = false
      } catch (e) {
        this.loading = false

        if (e.response.status === 422) {
          this.errors = e.response.data.errors
        }

        // MOVED the below code to axios.js plugin as axios interceptor
        // if (e.response.status === 423) {
        //   this.$router.replace({ name: 'confirm-password', query: { return: this.$route.name } })
        // }
      }
    }
  }
}
</script>
