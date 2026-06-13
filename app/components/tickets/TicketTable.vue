<script setup lang="ts">
import TicketRow from './TicketRow.vue';

const config = useRuntimeConfig();

const { data: ticketCollection, pending, error } = await useFetch(`${config.public.apiBase}/tickets`, {
    query: {
        departament: '/departaments/1'
    }
});
</script>

<template>
  <div class="p-6 max-w-6xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Fila de Chamados</h1>

    <div v-if="pending" class="text-sm text-gray-500">
      Carregando chamados do PostgreSQL...
    </div>

    <div v-else-if="error" class="p-4 bg-red-50 text-red-700 rounded">
      Falha ao conectar com o barramento do Kairós.
    </div>

    <div v-else class="space-y-3">
      
      <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-2 text-sm font-semibold text-gray-500 border-b dark:border-gray-800">
        <div class="col-span-2">Número</div>
        <div class="col-span-3">Título</div>
        <div class="col-span-3">Téc. Atribuído</div>
        <div class="col-span-2">Status</div>
        <div class="col-span-2 text-right">Abertura</div>
      </div>

      <TicketRow 
        v-for="ticket in ticketCollection?.member" 
        :key="ticket.id" 
        :ticket="ticket" 
      />

    </div>
  </div>
</template>