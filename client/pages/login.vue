<template>
  <div class="w-10/12 md:w-6/12 mx-auto">
    <form action="" @submit.prevent='login' class="mb-8">
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
          <input type="password" id="password" v-model="form.password" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.email }">

          <div v-if="errors.password" class="text-red-500 text-sm mt-2">
            {{ errors.password[0] }}
          </div>
        </div>

        <div class="mb-3">
          <nuxt-link :to="{ name: 'forgot-password' }">Forgot your password ?</nuxt-link>
        </div>
      </div>

      <c-button title="Login" type="submit" :loading="loading" :disabled="loading" />
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
        password: ''
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async login(){
      try {
        this.loading = true
        await this.$auth.loginWith('laravelSanctum', {
          data: this.form
        })
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
