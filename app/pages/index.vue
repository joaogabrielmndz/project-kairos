<script setup lang="ts">
import { ref } from 'vue';
import TicketTable from '~/components/tickets/TicketTable.vue';
import TicketCreateModal from '~/components/tickets/TicketCreateModal.vue';

// Controle de estado para abrir e fechar a modal do formulário
const isModalOpen = ref(false);
</script>

<template>
  <div>
    <TicketTable />

      <UButton
        @click="isModalOpen = true"
        icon="i-lucide-plus"
        size="xl"
        color="primary"
        variant="solid"
        aria-label="Abrir chamado"
        class="fixed bottom-8 right-8 w-14 h-14 rounded-full flex items-center justify-center shadow-2xl transition-opacity duration-200 hover:opacity-80 z-50"
      />

    <ClientOnly>
      <TicketCreateModal v-model="isModalOpen" />
    </ClientOnly>
  </div>
</template>