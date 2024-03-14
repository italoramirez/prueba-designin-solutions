<script setup lang="ts">
import {ref, inject, onMounted} from 'vue'
import UserDatatable from "@/components/private/User/components/UserDatatable.vue"

const drawer = ref(true)

</script>

<template>
  <UserDatatable
      :users="users"
  />
</template>

<style scoped>

</style>