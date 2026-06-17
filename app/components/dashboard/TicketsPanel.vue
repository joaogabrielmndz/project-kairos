<script setup lang="ts">
interface Ticket {
  number: string
  title: string
  description: string
  assignee: { name: string, initials: string, src?: string } | null
  status: { label: string, color: 'info' | 'warning' | 'error' | 'success' | 'neutral' }
  opened: string
  contato: string
  matricula: string
  departamento: string
  tipo: string
  localidade: string
  categoria: string
  acao: string
}

const props = defineProps<{
  tickets: Ticket[]
  total: number
}>()

const toast = useToast()

const tabs = [
  { label: 'Todos', badge: String(props.total) },
  { label: 'Meus Chamados' },
  { label: 'Não Atribuídos' },
  { label: 'Arquivados' }
]

const activeTab = ref(0)
const newTicketOpen = ref(false)

// Linha expandida (mostra descrição + ações)
const expanded = ref<string | null>(null)
function toggleExpand(number: string) {
  expanded.value = expanded.value === number ? null : number
}

// Modal de detalhes
const detailsOpen = ref(false)
const selectedTicket = ref<Ticket | null>(null)
function openDetails(ticket: Ticket) {
  selectedTicket.value = ticket
  detailsOpen.value = true
}

function startAttendance(ticket: Ticket) {
  toast.add({
    title: 'Atendimento iniciado',
    description: `Você iniciou o atendimento do chamado #${ticket.number}.`,
    icon: 'i-lucide-play',
    color: 'success'
  })
}

function onUpdate({ ticket, reason }: { ticket: Ticket, reason: string }) {
  toast.add({
    title: 'Chamado atualizado',
    description: `#${ticket.number} foi atualizado. Motivo: ${reason}`,
    icon: 'i-lucide-check',
    color: 'success'
  })
}

function onDelete({ ticket, reason }: { ticket: Ticket, reason: string }) {
  toast.add({
    title: 'Chamado excluído',
    description: `#${ticket.number} foi excluído. Motivo: ${reason}`,
    icon: 'i-lucide-trash-2',
    color: 'error'
  })
}
</script>

<template>
  <div class="rounded-xl border border-default bg-default shadow-sm">
    <!-- Toolbar: tabs + search + filter -->
    <div class="flex flex-col gap-4 border-b border-default p-4 lg:flex-row lg:items-center lg:justify-between">
      <nav class="flex items-center gap-6 overflow-x-auto">
        <button
          v-for="(tab, index) in tabs"
          :key="tab.label"
          class="flex items-center gap-2 whitespace-nowrap border-b-2 pb-2 text-sm font-medium transition-colors"
          :class="index === activeTab
            ? 'border-primary text-primary'
            : 'border-transparent text-muted hover:text-default'"
          @click="activeTab = index"
        >
          {{ tab.label }}
          <UBadge
            v-if="tab.badge"
            :label="tab.badge"
            color="primary"
            variant="solid"
            size="sm"
            class="rounded-full"
          />
        </button>
      </nav>

      <div class="flex items-center gap-2">
        <UButton
          icon="i-lucide-plus"
          label="Abrir Novo Chamado"
          color="primary"
          class="font-semibold"
          @click="newTicketOpen = true"
        />
        <UButton
          icon="i-lucide-sliders-horizontal"
          color="neutral"
          variant="outline"
          square
          aria-label="Filtrar"
        />
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-default bg-muted/40 text-left text-xs font-semibold uppercase tracking-wide text-muted">
            <th class="px-6 py-3">
              Número
            </th>
            <th class="px-6 py-3">
              Título
            </th>
            <th class="px-6 py-3">
              Téc. Atribuído
            </th>
            <th class="px-6 py-3">
              Status
            </th>
            <th class="px-6 py-3 text-right">
              Abertura
            </th>
          </tr>
        </thead>
        <tbody>
          <template
            v-for="ticket in tickets"
            :key="ticket.number"
          >
            <tr
              class="cursor-pointer border-b border-default transition-colors hover:bg-muted/40"
              :class="{ 'bg-muted/40': expanded === ticket.number }"
              @click="toggleExpand(ticket.number)"
            >
              <td class="whitespace-nowrap px-6 py-4 font-mono text-primary">
                <div class="flex items-center gap-2">
                  <UIcon
                    name="i-lucide-chevron-right"
                    class="size-4 text-dimmed transition-transform"
                    :class="{ 'rotate-90': expanded === ticket.number }"
                  />
                  #{{ ticket.number }}
                </div>
              </td>
              <td class="px-6 py-4 font-medium text-highlighted">
                {{ ticket.title }}
              </td>
              <td class="px-6 py-4">
                <div v-if="ticket.assignee" class="flex items-center gap-2">
                  <UAvatar
                    :src="ticket.assignee.src"
                    :text="ticket.assignee.initials"
                    :alt="ticket.assignee.name"
                    size="xs"
                    :ui="{ root: 'bg-primary text-inverted' }"
                  />
                  <span class="whitespace-nowrap text-default">{{ ticket.assignee.name }}</span>
                </div>
                <div v-else class="flex items-center gap-2">
                  <UAvatar text="--" size="xs" />
                  <span class="italic text-dimmed">Não atribuído</span>
                </div>
              </td>
              <td class="px-6 py-4">
                <UBadge
                  :label="ticket.status.label"
                  :color="ticket.status.color"
                  variant="subtle"
                  size="sm"
                  class="font-semibold uppercase"
                />
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-right text-muted">
                {{ ticket.opened }}
              </td>
            </tr>

            <!-- Linha expandida: descrição + ações -->
            <tr v-if="expanded === ticket.number" class="border-b border-default bg-muted/20">
              <td colspan="5" class="px-6 py-4">
                <div class="flex flex-col gap-4">
                  <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-muted">
                      Descrição
                    </p>
                    <p class="max-w-3xl text-sm leading-relaxed text-default">
                      {{ ticket.description }}
                    </p>
                  </div>
                  <div class="flex flex-wrap items-center gap-2">
                    <UButton
                      icon="i-lucide-play"
                      label="Iniciar Atendimento"
                      color="primary"
                      size="sm"
                      @click="startAttendance(ticket)"
                    />
                    <UButton
                      icon="i-lucide-maximize-2"
                      label="Ver Detalhes"
                      color="neutral"
                      variant="outline"
                      size="sm"
                      @click="openDetails(ticket)"
                    />
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Footer / pagination -->
    <div class="flex items-center justify-between border-t border-default px-6 py-4">
      <p class="text-sm text-muted">
        Mostrando 1-{{ tickets.length }} de {{ total }} chamados
      </p>
      <div class="flex items-center gap-2">
        <UButton
          icon="i-lucide-chevron-left"
          color="neutral"
          variant="outline"
          square
          disabled
          aria-label="Página anterior"
        />
        <UButton
          icon="i-lucide-chevron-right"
          color="neutral"
          variant="outline"
          square
          aria-label="Próxima página"
        />
      </div>
    </div>

    <DashboardNewTicketModal v-model:open="newTicketOpen" />
    <DashboardTicketDetailsModal
      v-model:open="detailsOpen"
      :ticket="selectedTicket"
      @update="onUpdate"
      @delete="onDelete"
    />
  </div>
</template>
