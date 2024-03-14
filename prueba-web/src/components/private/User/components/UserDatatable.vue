<script setup lang="ts">

import {onMounted, reactive, ref, inject} from 'vue'
import {PencilIcon, TrashIcon} from '@heroicons/vue/20/solid'
import type {User} from "@/components/private/User/interfaces/User"
import {LIST_USERS_URL, USER_URL} from "@/constants/UserConstants"
import {REGISTER_URL} from "@/constants/Authconstants"
import axios from "axios"
import Spinner from "@/components/private/Spinner/Spinner.vue";

const dialog = ref(false)
const dialogDelete = ref(false)
const users = ref([])
const isEditing = ref(false)

defineProps<{
  users: {
    type: Array,
    required: true
  }
}>()

const headers = reactive([
  {
    title: 'Nombre',
    align: 'start',
    sortable: false,
    key: 'name',
  },
  {title: 'Email', key: 'email'},
  {title: 'Edad', key: 'age'},
  {title: 'Dirección', key: 'address'},
  {title: 'Acciones', key: 'actions', sortable: false}
])

const initialState: User = {
  id: null,
  name: '',
  email: '',
  age: '',
  address: ''
}

const errors = reactive({
  age: null,
  name: null,
  email: null,
  address: null
})

const model = reactive<User>({...initialState})

const getUsers = async () => {
  try {
    const response = await axios.get(`${LIST_USERS_URL}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
      }
    })
    users.value = response.data
  } catch (e) {
      console.error(e)
  }
}

const loadUser = async (id: number) => {
  try {
    dialog.value = true
    isEditing.value = true
    const response = await axios.get(`${LIST_USERS_URL}/show/${id}`, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
      }
    })
    if (response.status === 200) {
      model.id = response.data.id
      model.name = response.data.name
      model.email = response.data.email
      model.age = response.data.age
      model.address = response.data.address
    }
  } catch (e) {
    console.error(e)
  }
}

const validateEmail = (email) => {
  const re =/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i
  return re.test(String(email).toLowerCase());
}

const validate = () => {
  if (!model.name) {
    errors.name = 'El nombre es requerido'
    return false
  }
  if (!model.email || validateEmail(model.email)) {
    errors.email = 'El email es requerido o no es válido'
    return false
  }
  if (!model.age || model.age === 0 || isNaN(model.age)) {
    errors.age = 'La edad es requerida y debe ser un número mayor a cero'
    return false
  }
  if (!model.address || model.address.length < 6) {
    errors.address = 'La dirección es requerida y debe contener mínino 6 carácteres'
    return false
  }
  return true
}

const save = async () => {
  try {
    if (model.id) {
      await updateUser(model.id)
    } else {
      if (!validate()) return
      const response = await axios.post(`${REGISTER_URL}`, model, {
        headers: {
          'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
        }
      })
      if (response.status === 200) {
        Swal.fire({
          title: "¡Éxitoso!",
          text: "Usuario creado correctamente",
          icon: "success"
        })
        dialog.value = false
      }
    }
    await getUsers()
  } catch (error) {
    console.error(error)
  }
}

const updateUser = async (id: number) => {
  try {
    const response = await axios.put(`${USER_URL}/${id}`, model, {
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
      }
    })
    if (response.status === 200) {
      Swal.fire({
        title: "¡Éxitoso!",
        text: "Usuario actualizado correctamente",
        icon: "success"
      })
        dialog.value = false
        await getUsers()
    }
  } catch (error) {
    console.error(error)
  }
}

const deleteUser = async (id: number) => {
  Swal.fire({
    title: "¿Está seguro de eliminar el usuario?",
    cancelButtonText: "Cancelar",
    showCancelButton: true,
    confirmButtonText: "Confirmar",
    confirmButtonColor: 'red',
    cancelButtonColor: 'black',
    allowOutsideClick: false
  }).then(async (result: any) => {
    if (result.isConfirmed) {
      try {
        const response = await axios.delete(`${USER_URL}/${id}`, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('auth/tk')}`
          }
        })
        if (response.status === 204) {
          Swal.fire({
            title: "¡Éxitoso!",
            text: "Usuario eliminado correctamente",
            icon: "success"
          })
          await getUsers()
        }
      } catch (e) {
        console.error(e)
      }
    }
  })
}

const close = () => {
  isEditing.value = false
  dialog.value = false
  model.id = null
  model.name = ''
  model.email = ''
  model.age = ''
  model.address = ''
  getUsers()
}

onMounted(async () => {
  await getUsers()
})

</script>

<template>
  <div    v-if ="users.length === 0" class="d-flex justify-center align-center my-10">
    <Spinner />
  </div>
  <v-data-table
      v-else
      v-if="users.length  > 0"
      :headers="headers"
      :items="users"
      :sort-by="[{ key: 'calories', order: 'asc' }]"
  >
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Registro usuarios</v-toolbar-title>
        <div class="pa-4 text-center">
          <v-dialog
              v-model="dialog"
              max-width="600"
          >
            <template v-slot:activator="{ props: activatorProps }">
              <v-btn
                  class="text-none font-weight-regular"
                  prepend-icon="mdi-account"
                  text="Nuevo usuario"
                  v-bind="activatorProps"
              ></v-btn>
            </template>

            <form novalidate @submit.prevent="save">
              <v-card
                  prepend-icon="mdi-account"
                  title="Crear Usuario"
              >
                <v-card-text>
                  <v-row dense>
                    <v-col
                        cols="12"
                        md="4"
                        sm="6"
                    >
                      <v-text-field
                          v-model="model.name"
                          label="Nombre*"
                          required
                          v-vind="nameAttrs"
                      ></v-text-field>
                      <div v-if="!model.name">
                        <span class="text-red text-caption mt-0">{{ errors.name }}</span>
                      </div>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                        sm="6"
                    >
                      <v-text-field
                          v-model="model.age"
                          type="number"
                          label="Edad"
                      ></v-text-field>
                      <div v-if="!model.age">
                        <span class="text-red text-caption">{{ errors.age }}</span>
                      </div>
                    </v-col>
                    <v-col
                        v-if="!isEditing"
                        cols="12"
                        md="4"
                        sm="6"
                    >
                      <v-text-field
                          v-model="model.email"
                          label="Email*"
                          type="email"
                          required
                      ></v-text-field>
                      <div v-if="!model.email || errors.email">
                        <span class="text-red text-caption">{{ errors.email }}</span>
                      </div>
                    </v-col>

                    <v-col
                        cols="12"
                        md="4"
                        sm="6"
                    >
                      <v-text-field
                          v-model="model.address"
                          label="Dirección*"
                          required
                      ></v-text-field>
                      <div v-if="!errors.addres">
                        <span class="text-red text-caption">{{ errors.address }}</span>
                      </div>
                    </v-col>

                    <v-col
                        v-if="!isEditing"
                        cols="12"
                        md="4"
                        sm="6"
                    >
                      <v-text-field
                          v-model="model.password"
                          label="Password*"
                          type="password"
                          required
                      ></v-text-field>
                    </v-col>
                  </v-row>

                  <small class="text-caption text-medium-emphasis">*Campos requeridos</small>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                  <v-spacer></v-spacer>

                  <v-btn
                      text="Cerrar"
                      variant="plain"
                      @click="close"
                  ></v-btn>

                  <v-btn
                      color="primary"
                      text="Guardar"
                      variant="tonal"
                      type="submit"
                  ></v-btn>
                </v-card-actions>
              </v-card>
            </form>
          </v-dialog>
        </div>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <PencilIcon style="width: 20px" class="cursor-pointer mr-10" @click="loadUser(item.id)"></PencilIcon>
      <TrashIcon style="width: 20px" @click="deleteUser(item.id)" class="cursor-pointer"></TrashIcon>
    </template>
  </v-data-table>
</template>