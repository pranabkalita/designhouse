<template>
  <div class="w-10/12 md:w-6/12 mx-auto">
    <form action="" @submit.prevent='updateProfileInformation' class="mb-8">
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
      </div>

      <div class="mb-3">
        <nuxt-link :to="{ name: 'delete' }">Delete Account</nuxt-link>
      </div>

      <c-button title="Update Profile" type="submit" :loading="loading" :disabled="loading" />
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: this.$auth.user.email,
        name: this.$auth.user.name
      },

      loading: false,
      errors: [],
    }
  },
  methods: {
    async updateProfileInformation() {
      try {
        this.loading = true
        await this.$axios.get('sanctum/csrf-cookie')
        await this.$axios.put('user/profile-information', this.form)

        await this.$auth.fetchUser()
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
