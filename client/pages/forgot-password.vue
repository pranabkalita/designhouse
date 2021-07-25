<template>
  <div class="w-10/12 md:w-6/12 mx-auto">
    <form action="" @submit.prevent='sendForgotPasswordEmail' class="mb-8">
      <div class="mb-6">
        <div class="mb-3">
          <label for="email" class="inline-block text-sm mb-2">Email</label>
          <input type="text" id="email" v-model="form.email" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.email }">

          <div v-if="errors.email" class="text-red-500 text-sm mt-2">
            {{ errors.email[0] }}
          </div>
        </div>
      </div>

      <c-button title="Recover Password" type="submit" :loading="loading" :disabled="loading" />
    </form>

    <p class="text-sm text-gray-800">
      Not joined yet ?
      <router-link :to="{ name: 'register' }" class="text-indigo-500">Create an account</router-link>
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: '',
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async sendForgotPasswordEmail(){
      try {
        this.loading = true
        await this.$axios.get('sanctum/csrf-cookie')
        await this.$axios.post('forgot-password', this.form)

        this.loading = false
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
