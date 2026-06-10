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

      <template #right>
        <UColorModeButton />

        <AppUserMenu />
      </template>
    </UHeader>
</template>