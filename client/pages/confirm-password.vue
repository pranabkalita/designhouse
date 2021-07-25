<template>
  <div class="w-10/12 md:w-6/12 -mx-3">
    <form action="" @submit.prevent='confirmPassword' class="mb-8">
      <div class="mb-6">
        <div class="mb-3">
          <label for="password" class="inline-block text-sm mb-2">Password</label>
          <input type="password" id="password" v-model="form.password" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.email }">

          <div v-if="errors.password" class="text-red-500 text-sm mt-2">
            {{ errors.password[0] }}
          </div>
        </div>
      </div>

      <c-button title="Confirm Password" type="submit" :loading="loading" :disabled="loading" />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        password: ''
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async confirmPassword(){
      try {
        this.loading = true

        await this.$axios.get('sanctum/csrf-cookie')
        await this.$axios.post('user/confirm-password', this.form)

        this.loading = false
        this.$router.replace({ name: this.$route.query.return || 'index' })
      } catch (e) {
        this.loading = false
        if (e.response.status === 422) {
          this.errors = e.response.data.errors
        }
      }
    }
  }
}
</script>
