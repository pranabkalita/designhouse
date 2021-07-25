<template>
  <div class="w-10/12 md:w-6/12 mx-auto">
    <form action="" @submit.prevent='register' class="mb-8">
      <div class="mb-6">
        <div class="mb-3">
          <label for="name" class="inline-block text-sm mb-2">Name</label>
          <input type="text" id="name" v-model="form.name" class="w-full border-2 border-gray-200 h-10 px-3 rounded-md" :class="{ 'border-red-500': errors.name }">

          <div v-if="errors.name" class="text-red-500 text-sm mt-2">
            {{ errors.name[0] }}
          </div>
        </div>

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
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async register(){
      try {
        this.loading = true
        await this.$axios.get('sanctum/csrf-cookie')
        await this.$axios.post('register', this.form)

        await this.$auth.loginWith('laravelSanctum', {
          data: { email: this.form.email, passwrod: this.form.password }
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
