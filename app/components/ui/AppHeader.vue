<script setup lang="ts">
import AppUserMenu from './AppUserMenu.vue';

const search = ref('')
</script>

<template>
  <UHeader :ui="{ center: 'flex-1 justify-center px-4' }">
    <template #left>
      <NuxtLink to="/" class="text-2xl font-bold text-primary">
        Kairós
      </NuxtLink>
    </template>

    <div class="mx-auto w-full max-w-xl">
      <UInput
        v-model="search"
        icon="i-lucide-search"
        placeholder="Buscar chamados..."
        size="lg"
        class="w-full"
      />
    </div>

    <template #right>
      <UColorModeButton />

      <UButton
        icon="i-lucide-bell"
        color="neutral"
        variant="ghost"
        aria-label="Notificações"
      />

      <AppUserMenu />
    </template>
  </UHeader>
</template>
