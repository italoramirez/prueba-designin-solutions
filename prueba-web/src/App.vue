<script setup lang="ts">
import {useRouter} from 'vue-router'
import {shallowRef} from 'vue'
import layouts from '@/layouts'

const router = useRouter()
const layout = shallowRef('div')

router.afterEach((to) => {
  layout.value = layouts[to.meta.layout] || 'div'
})

</script>

<template>
  <component :is="layout">
    <router-view></router-view>
  </component>
</template>