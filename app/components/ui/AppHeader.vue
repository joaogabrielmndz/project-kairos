<script setup lang="ts">
import AppUserMenu from './AppUserMenu.vue';

</script>

<template>
    <UHeader>
      <template #left>
        <NuxtLink to="/">
          <span class="text-2xl">Kairos</span>
        </NuxtLink>
      </template>

      <template #center>
        <UInput class="w-full flex-1" icon="i-lucide-search" size="xl" variant="outline" placeholder="Buscar por um chamado" />
      </template>

      <template #right>
        <UColorModeButton />

        <AppUserMenu />
      </template>
    </UHeader>
</template>