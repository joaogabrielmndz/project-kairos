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

const open = defineModel<boolean>('open', { default: false })

const props = defineProps<{
  ticket: Ticket | null
}>()

const emit = defineEmits<{
  (e: 'update', payload: { ticket: Ticket, reason: string }): void
  (e: 'delete', payload: { ticket: Ticket, reason: string }): void
}>()

const departamentos = [
  'Tecnologia da Informação',
  'Recursos Humanos',
  'Financeiro',
  'Operações',
  'Comercial'
]

// Mode: 'view' | 'edit' | 'delete'
const mode = ref<'view' | 'edit' | 'delete'>('view')

const form = reactive({
  matricula: '',
  contato: '',
  titulo: '',
  descricao: '',
  departamento: '' as string,
  tipo: '',
  localidade: '',
  categoria: '',
  acao: ''
})

const editReason = ref('')
const deleteReason = ref('')

function syncFromTicket() {
  if (!props.ticket) return
  form.matricula = props.ticket.matricula
  form.contato = props.ticket.contato
  form.titulo = props.ticket.title
  form.descricao = props.ticket.description
  form.departamento = props.ticket.departamento
  form.tipo = props.ticket.tipo
  form.localidade = props.ticket.localidade
  form.categoria = props.ticket.categoria
  form.acao = props.ticket.acao
}

// Re-sync whenever the modal opens or the ticket changes.
watch(
  () => [open.value, props.ticket] as const,
  ([isOpen]) => {
    if (isOpen) {
      mode.value = 'view'
      editReason.value = ''
      deleteReason.value = ''
      syncFromTicket()
    }
  },
  { immediate: true }
)

const readonly = computed(() => mode.value !== 'edit')

const title = computed(() => {
  if (mode.value === 'edit') return 'Editar Chamado'
  if (mode.value === 'delete') return 'Excluir Chamado'
  return 'Detalhes do Chamado'
})

function startEdit() {
  mode.value = 'edit'
}

function startDelete() {
  mode.value = 'delete'
}

function cancelAction() {
  // Volta para a visualização e descarta alterações.
  mode.value = 'view'
  editReason.value = ''
  deleteReason.value = ''
  syncFromTicket()
}

function confirmEdit() {
  if (!props.ticket || !editReason.value.trim()) return
  emit('update', { ticket: { ...props.ticket }, reason: editReason.value.trim() })
  open.value = false
}

function confirmDelete() {
  if (!props.ticket || !deleteReason.value.trim()) return
  emit('delete', { ticket: props.ticket, reason: deleteReason.value.trim() })
  open.value = false
}
</script>

<template>
  <UModal
    v-model:open="open"
    :title="title"
    :ui="{ content: 'max-w-xl' }"
  >
    <template #body>
      <div v-if="ticket" class="space-y-4">
        <!-- Cabeçalho do chamado -->
        <div class="flex flex-wrap items-center justify-between gap-2">
          <span class="font-mono text-sm text-primary">#{{ ticket.number }}</span>
          <UBadge
            :label="ticket.status.label"
            :color="ticket.status.color"
            variant="subtle"
            size="sm"
            class="font-semibold uppercase"
          />
        </div>

        <!-- Confirmação de exclusão -->
        <div v-if="mode === 'delete'" class="space-y-4">
          <UAlert
            icon="i-lucide-triangle-alert"
            color="error"
            variant="subtle"
            title="Esta ação não pode ser desfeita"
            :description="`Você está prestes a excluir o chamado #${ticket.number} - ${ticket.title}.`"
          />
          <UFormField label="Motivo da exclusão" required>
            <UTextarea
              v-model="deleteReason"
              :rows="3"
              placeholder="Descreva o motivo da exclusão deste chamado..."
              class="w-full"
            />
          </UFormField>
        </div>

        <!-- Formulário (view / edit) -->
        <form v-else class="space-y-4" @submit.prevent>
          <UFormField label="Contato">
            <div
              class="flex items-stretch overflow-hidden rounded-md border bg-default"
              :class="readonly ? 'border-default bg-muted/40' : 'border-accented focus-within:ring-2 focus-within:ring-primary'"
            >
              <input
                v-model="form.matricula"
                type="text"
                placeholder="Matrícula"
                :readonly="readonly"
                class="w-28 shrink-0 bg-transparent px-3 py-2 text-sm text-default outline-none placeholder:text-dimmed read-only:text-muted"
              >
              <span class="my-1 w-px bg-accented" aria-hidden="true" />
              <input
                v-model="form.contato"
                type="text"
                placeholder="Nome do solicitante"
                :readonly="readonly"
                class="min-w-0 flex-1 bg-transparent px-3 py-2 text-sm text-default outline-none placeholder:text-dimmed read-only:text-muted"
              >
            </div>
          </UFormField>

          <UFormField label="Título">
            <UInput v-model="form.titulo" :readonly="readonly" class="w-full" />
          </UFormField>

          <UFormField label="Descrição">
            <UTextarea v-model="form.descricao" :rows="4" :readonly="readonly" class="w-full" />
          </UFormField>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <UFormField label="Departamento">
              <USelect
                v-if="!readonly"
                v-model="form.departamento"
                :items="departamentos"
                class="w-full"
              />
              <UInput v-else v-model="form.departamento" readonly class="w-full" />
            </UFormField>

            <UFormField label="Tipo">
              <UInput v-model="form.tipo" :readonly="readonly" class="w-full" />
            </UFormField>

            <UFormField label="Localidade">
              <UInput v-model="form.localidade" :readonly="readonly" class="w-full" />
            </UFormField>

            <UFormField label="Categoria">
              <UInput v-model="form.categoria" :readonly="readonly" class="w-full" />
            </UFormField>

            <UFormField label="Ação" class="sm:col-start-2">
              <UInput v-model="form.acao" :readonly="readonly" class="w-full" />
            </UFormField>
          </div>

          <!-- Motivo da edição -->
          <UFormField v-if="mode === 'edit'" label="Motivo da edição" required>
            <UTextarea
              v-model="editReason"
              :rows="2"
              placeholder="Descreva o motivo da alteração deste chamado..."
              class="w-full"
            />
          </UFormField>
        </form>
      </div>
    </template>

    <template #footer>
      <!-- Ações: visualização -->
      <div v-if="mode === 'view'" class="flex w-full items-center justify-between gap-3">
        <UButton
          label="Excluir"
          icon="i-lucide-trash-2"
          color="error"
          variant="ghost"
          @click="startDelete"
        />
        <div class="flex items-center gap-3">
          <UButton label="Fechar" color="neutral" variant="ghost" @click="open = false" />
          <UButton label="Editar" icon="i-lucide-pencil" color="primary" @click="startEdit" />
        </div>
      </div>

      <!-- Ações: edição -->
      <div v-else-if="mode === 'edit'" class="flex w-full items-center justify-end gap-3">
        <UButton label="Cancelar" color="neutral" variant="ghost" @click="cancelAction" />
        <UButton
          label="Confirmar Edição"
          color="primary"
          :disabled="!editReason.trim()"
          @click="confirmEdit"
        />
      </div>

      <!-- Ações: exclusão -->
      <div v-else class="flex w-full items-center justify-end gap-3">
        <UButton label="Cancelar" color="neutral" variant="ghost" @click="cancelAction" />
        <UButton
          label="Confirmar Exclusão"
          icon="i-lucide-trash-2"
          color="error"
          :disabled="!deleteReason.trim()"
          @click="confirmDelete"
        />
      </div>
    </template>
  </UModal>
</template>
