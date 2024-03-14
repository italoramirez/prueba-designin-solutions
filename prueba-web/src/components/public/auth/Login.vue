<script setup lang="ts">
import {reactive, ref} from 'vue'
import {useField, useForm} from 'vee-validate'
import {useAuthStore} from "@/stores/auth.store"
import {useRouter} from "vue-router"

const authStore = useAuthStore()
const router = useRouter()

const password = ref('')
const email = ref('')

const errors = reactive({
  password: null,
  email: null,
  message: null
})

const validateEmail = (email) => {
  const re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
  return re.test(String(email).toLowerCase());
}

const validate = () => {
  if (!email.value || !validateEmail(email.value)) {
    console.log(email.value)
    errors.email = 'El email es requerido o no es válido'
    return false
  }
  if (!password.value || password.value < 6) {
    errors.password = 'La dirección es requerida y debe contener mínino 6 carácteres'
    return false
  }
  return true
}

const clear = () => {
  email.value = ''
  password.value = ''
  errors.email = null
  errors.password = null
  errors.message = null
}

const submit = async () => {
  try {
    if (!validate()) return
    await authStore.login(email.value, password.value, router);
  } catch (e) {
    if (e.response.status === 401) {
      errors.message = 'Usuario no autorizado para ingresar'
      await router.push({name: 'login'})
    }
    if (e.response.status === 500) {
      errors.message = 'Email o contraseña no validas o no existe el usuario'
    }
    console.error(e);
  }
}

</script>

<template>
  <v-container class="fill-height" fluid>
    <v-row
        align="center"
        justify="center"
    >
      <form novalidate @submit.prevent="submit">
        <div>
          <v-text-field
              v-model="email"
              label="E-mail"
              type="email"
              :style="{ width: '400px' }"
          ></v-text-field>
          <div v-if="email">
            <span class="text-red text-caption my-3">{{ errors.email }}</span>
          </div>
        </div>
        <v-text-field
            v-model="password"
            label="Password"
            type="password"
        ></v-text-field>
        <div v-if="password">
          <span class="text-red text-caption my-3">{{ errors.password }}</span>
        </div>
        <div>
          <div v-if="errors.message">
            <span class="text-red text-caption my-3">{{ errors.message }}</span>
          </div>
        </div>
        <v-btn
            class="me-4 my-3"
            type="submit"
        >
          Ingresar
        </v-btn>

        <v-btn @click="clear">
          Limpiar
        </v-btn>
      </form>
    </v-row>
  </v-container>
</template>
