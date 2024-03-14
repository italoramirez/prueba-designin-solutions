<script setup lang="ts">

import { ref } from 'vue'
import { useAuthStore } from "@/stores/auth.store"
import {useRouter} from "vue-router"
import axios from "axios"
import {LOGOUT_URL} from "@/constants/Authconstants"
import {LIST_USERS_URL} from "@/constants/UserConstants";

const authStore = useAuthStore()
const router = useRouter()
const user = ref(null)

user.value = !authStore.user ? 'No hay usuario registrado' : authStore.user.name

const drawer = ref(true)
const rail = ref(true)

const logout = async () => {
  console.log(LOGOUT_URL)
  try {
    const response = await axios.post(LOGOUT_URL, null, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
      }
    })
    if (response.status === 200) {
      authStore.logout()
      await router.push({name: 'login'})
    }
  } catch (e) {
    console.log(e)
  }
}

const getInitialName = () => {
  if (authStore.user?.name) {
    const [firstName, lastName] = authStore.user.name.split(' ');
    return `${firstName[0]}${lastName ? lastName[0] : ''}`;
  }
  return '';
}

</script>
<template>
  <v-card>
    <v-layout>
      <v-navigation-drawer
          v-model="drawer"
          :rail="rail"
          permanent
          @click="rail = false"
      >
        <v-list-item
            prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg"
            :title="`${user}`"
            nav
        >
          <template v-slot:append>
            <v-btn
                icon="mdi-chevron-left"
                variant="text"
                @click.stop="rail = !rail"
            ></v-btn>
          </template>
        </v-list-item>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <router-link to="/" class="text-decoration-none bg-blue-grey-lighten-5">
            <v-list-item prepend-icon="mdi-account-group-outline" title="Usuarios" value="user"></v-list-item>
          </router-link>
          <v-list-item prepend-icon="mdi-account-group-outline" title="Cerrar sesión" @click="logout"></v-list-item>
        </v-list>
      </v-navigation-drawer>
      <v-main style="height: 1350px">
        <router-view></router-view>
      </v-main>
    </v-layout>
  </v-card>
</template>