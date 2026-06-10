<script setup>
const menuItems = [
  [
    {
      label: 'Meu Perfil',
      icon: 'i-lucide-user',
      to: '/perfil'
    },
    {
      label: 'Configurações',
      icon: 'i-lucide-settings'
    }
  ],
  [
    {
      label: 'Sair do Sistema',
      icon: 'i-lucide-log-out',
      color: 'error',
      click: () => {
        console.log('Logout disparado')
      }
    }
  ]
]
</script>

<template>
  <UDropdownMenu
    :items="menuItems"
    :content="{ align: 'end' }"
    :modal="false"
  >
    <button class="focus:outline-none block cursor-pointer rounded-full transition hover:opacity-80">
      <UAvatar
        alt="Foto do Usuário"
        size="md"
        loading="lazy"
      />
    </button>
  </UDropdownMenu>
</template>