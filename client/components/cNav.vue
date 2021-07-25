<template>
  <header class="flex flex-wrap md:flex-no-wrap item-center justify-between mb-6 -mx-3 -mt-3">
    <ul class="flex items-center mb-6 -mx-2">
      <li><nuxt-link :to="{ name: 'home' }" class="px-2">Home</nuxt-link></li>

      <template v-if="$auth.loggedIn">
        <li><nuxt-link :to="{ name: 'profile' }" class="px-2">{{ $auth.user.name }}</nuxt-link></li>
        <li><nuxt-link :to="{ name: 'dashboard' }" class="px-2">Dashbaord</nuxt-link></li>
        <li><a href="#" @click.prevent="logout" class="px-2">Logout</a></li>
      </template>

      <template v-if="!$auth.loggedIn">
        <li><nuxt-link :to="{ name: 'login' }" class="px-2">Login</nuxt-link></li>
        <li><nuxt-link :to="{ name: 'register' }" class="px-2">Register</nuxt-link></li>
      </template>
    </ul>
  </header>
</template>

<script>
export default {
  methods: {
    async logout() {
      await this.$auth.logout()
      this.$router.replace({ name: 'index' })
    }
  }
}
</script>
