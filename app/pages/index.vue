<script setup lang="ts">
import StatCard from '~/components/dashboard/StatCard.vue';
import TicketsPanel from '~/components/dashboard/TicketsPanel.vue';

const today = new Intl.DateTimeFormat('pt-BR', {
  weekday: 'long',
  day: 'numeric',
  month: 'long',
  year: 'numeric'
}).format(new Date())

const stats = [
  { label: 'Em Atendimento', value: 42, accent: 'green' as const, trend: 'up' as const, trendLabel: '+5% vs ontem' },
  { label: 'Aguardando', value: 18, accent: 'yellow' as const, trend: 'stable' as const, trendLabel: 'Estável' },
  { label: 'Suspensos', value: 3, accent: 'red' as const, trend: 'down' as const, trendLabel: '-2 vs ontem' },
  { label: 'Encerrados (Hoje)', value: 124, accent: 'blue' as const, trend: 'goal' as const, trendLabel: '+12% vs meta' }
]

const tickets = [
  {
    number: '2026000001',
    title: 'Mouse óptico não liga',
    description: 'O mouse óptico do colaborador parou de funcionar completamente. Já foi testado em outra porta USB e em outro computador, sem sucesso. Provável defeito de hardware no sensor.',
    assignee: { name: 'João Gabriel', initials: 'JG' },
    status: { label: 'Em Atendimento', color: 'info' as const },
    opened: 'Há 2 horas',
    contato: 'Carlos Mendes',
    matricula: '004512',
    departamento: 'Operações',
    tipo: 'T.I Incidente',
    localidade: 'Bloco B, Sala 04',
    categoria: 'Computador',
    acao: 'Manutenção'
  },
  {
    number: '2026558677',
    title: 'Monitor sem vídeo após queda de energia',
    description: 'Após uma queda de energia no setor, o monitor não exibe imagem. O LED de energia acende, mas a tela permanece preta. Necessário verificar fonte e cabo de vídeo.',
    assignee: null,
    status: { label: 'Aguardando', color: 'warning' as const },
    opened: 'Há 3 horas',
    contato: 'Patrícia Lopes',
    matricula: '009823',
    departamento: 'Financeiro',
    tipo: 'T.I Incidente',
    localidade: 'Bloco A, Sala 12',
    categoria: 'Monitor',
    acao: 'Manutenção'
  },
  {
    number: '2026558672',
    title: 'Sistema ERP apresentando lentidão',
    description: 'O sistema ERP está extremamente lento para todos os usuários do setor comercial desde o início da manhã. Telas demoram mais de 30 segundos para carregar. Impacto crítico na operação.',
    assignee: { name: 'Ana Silva', initials: 'AS' },
    status: { label: 'Urgente', color: 'error' as const },
    opened: 'Ontem',
    contato: 'Roberto Dias',
    matricula: '001207',
    departamento: 'Comercial',
    tipo: 'T.I Incidente',
    localidade: 'Bloco C, Sala 01',
    categoria: 'Software',
    acao: 'Suporte'
  }
]
</script>

<template>
  <UContainer class="py-8">
    <!-- Greeting -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
      <div>
        <h1 class="text-3xl font-bold text-highlighted">
          Olá, Técnico
        </h1>
        <p class="mt-1 text-muted">
          {{ today }}
        </p>
      </div>
      <UButton
        icon="i-lucide-download"
        label="Exportar Relatório"
        color="neutral"
        variant="outline"
      />
    </div>

    <!-- Stat cards -->
    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <StatCard
        v-for="stat in stats"
        :key="stat.label"
        v-bind="stat"
      />
    </div>

    <!-- Tickets -->
    <div class="mt-6">
      <TicketsPanel :tickets="tickets" :total="187" />
    </div>
  </UContainer>
</template>
