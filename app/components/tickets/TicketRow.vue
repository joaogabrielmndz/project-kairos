<script setup lang="ts">
import { ref } from 'vue';

defineProps({
  ticket: {
    type: Object,
    required: true
  }
});

const isExpanded = ref(false);

const toggleExpand = () => {
  isExpanded.value = !isExpanded.value;
};

const getStatusColor = (status: string) => {
  const colors: Record<string, string> = {
    pending: 'warning',
    in_progress: 'info',
    suspended: 'neutral',
    cancelled: 'error',
    closed: 'sucess'
  };
  return colors[status] || 'neutral';
};

const getStatusLabel = (status: string) => {
  const labels: Record<string, string> = {
    pending: 'Aguardando Atendimento',
    in_progress: 'Em Atendimento',
    suspended: 'Suspenso',
    cancelled: 'Cancelado',
    closed: 'Encerrado'
  };
  
  return labels[status] || status; 
};

</script>

<template>
  <div class="border border-gray-200 dark:border-gray-800 rounded-lg bg-white dark:bg-gray-900 overflow-hidden transition-all duration-200 hover:border-primary-500">
    
    <div 
      @click="toggleExpand"
      class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center p-4 cursor-pointer select-none"
    >
      <div class="col-span-2 font-mono text-sm text-gray-600 dark:text-gray-400">
        #{{ ticket.ticketNumber }}
      </div>

      <div class="col-span-3 font-medium text-gray-900 dark:text-white truncate" :title="ticket.title">
        {{ ticket.title }}
      </div>

      <div class="col-span-3 flex items-center gap-2">
        <template v-if="ticket.assignedTo">
          <UAvatar :alt="ticket.assignedTo.fullName" size="xs" class="bg-primary-500 text-white" />
          <span class="text-sm text-gray-700 dark:text-gray-300 truncate">{{ ticket.assignedTo.fullName }}</span>
        </template>
        <template v-else>
          <span class="text-sm text-gray-400 italic flex items-center gap-1.5">
            <UIcon name="i-lucide-user-x" class="w-4 h-4" /> Sem responsável
          </span>
        </template>
      </div>

      <div class="col-span-2">
        <UBadge :color="getStatusColor(ticket.status)" variant="subtle" class="uppercase text-xs font-bold">
          {{ getStatusLabel(ticket.status) }}
        </UBadge>
      </div>

      <div class="col-span-2 flex items-center justify-between text-sm text-gray-500">
        <span>Há 2 horas</span>
        <UIcon 
          name="i-lucide-chevron-down" 
          class="w-5 h-5 transition-transform duration-200 text-gray-400"
          :class="{ 'rotate-180': isExpanded }"
        />
      </div>
    </div>

    <div 
      v-show="isExpanded"
      class="p-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50"
    >
      <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Descrição do Incidente</h4>
      <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
        {{ ticket.description }}
      </p>
      
      <div class="mt-5 flex gap-3">
        <UButton size="sm" color="primary" icon="i-lucide-play">Iniciar atendimento</UButton>
        <UButton size="sm" color="neutral" variant="soft" icon="i-lucide-maximize-2">Ver Mais</UButton>
      </div>
    </div>

  </div>
</template>