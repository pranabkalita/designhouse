<template>
  <div class="w-10/12 md:w-6/12 mx-auto">
    <form action="" @submit.prevent='resetPassword' class="mb-8">
      <div class="mb-6">
        <div class="mb-3">
          <label for="email" class="inline-block text-sm mb-2">Email</label>
          <input type="text" id="email" v-model="form.email" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.email }">

          <div v-if="errors.email" class="text-red-500 text-sm mt-2">
            {{ errors.email[0] }}
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="inline-block text-sm mb-2">Password</label>
          <input type="password" id="password" v-model="form.password" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.password }">

          <div v-if="errors.password" class="text-red-500 text-sm mt-2">
            {{ errors.password[0] }}
          </div>
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="inline-block text-sm mb-2">Password confirmation</label>
          <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.password_confirmation }">

          <div v-if="errors.password_confirmation" class="text-red-500 text-sm mt-2">
            {{ errors.password_confirmation[0] }}
          </div>
        </div>
      </div>

      <c-button title="Change Password" type="submit" :loading="loading" :disabled="loading" />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: this.$route.query.email || '',
        password: '',
        password_confirmation: '',
        token: this.$route.query.token || ''
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async resetPassword(){
      try {
        this.loading = true
        await this.$axios.get('sanctum/csrf-cookie')
        await this.$axios.post('reset-password', this.form)

        this.loading = false
        this.$router.replace({ name: 'login' })
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
