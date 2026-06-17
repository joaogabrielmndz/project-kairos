<script setup lang="ts">
const open = defineModel<boolean>('open', { default: false })

const state = reactive({
  matricula: '',
  contato: '',
  titulo: '',
  descricao: '',
  departamento: undefined as string | undefined,
  tipo: 'T.I Incidente',
  localidade: '',
  categoria: 'Computador',
  acao: 'Manutenção'
})

const departamentos = [
  'Tecnologia da Informação',
  'Recursos Humanos',
  'Financeiro',
  'Operações',
  'Comercial'
]

function resetForm() {
  state.matricula = ''
  state.contato = ''
  state.titulo = ''
  state.descricao = ''
  state.departamento = undefined
  state.tipo = 'T.I Incidente'
  state.localidade = ''
  state.categoria = 'Computador'
  state.acao = 'Manutenção'
}

function onCancel() {
  open.value = false
}

function onSubmit() {
  // Em produção, enviar para a API de chamados.
  open.value = false
  resetForm()
}
</script>

<template>
  <UModal
    v-model:open="open"
    title="Abrir Novo Chamado"
    :ui="{ content: 'max-w-xl' }"
  >
    <template #body>
      <form class="space-y-4" @submit.prevent="onSubmit">
        <!-- Contato (merged field: matrícula + nome) -->
        <UFormField label="Contato">
          <div class="flex items-stretch overflow-hidden rounded-md border border-accented bg-default focus-within:ring-2 focus-within:ring-primary">
            <input
              v-model="state.matricula"
              type="text"
              placeholder="Matrícula"
              class="w-28 shrink-0 bg-transparent px-3 py-2 text-sm text-default outline-none placeholder:text-dimmed"
            >
            <span class="my-1 w-px bg-accented" aria-hidden="true" />
            <input
              v-model="state.contato"
              type="text"
              placeholder="Nome do solicitante"
              class="min-w-0 flex-1 bg-transparent px-3 py-2 text-sm text-default outline-none placeholder:text-dimmed"
            >
          </div>
        </UFormField>

        <UFormField label="Título">
          <UInput
            v-model="state.titulo"
            placeholder="Resumo do problema"
            class="w-full"
          />
        </UFormField>

        <UFormField label="Descrição">
          <UTextarea
            v-model="state.descricao"
            :rows="4"
            placeholder="Detalhes da solicitação..."
            class="w-full"
          />
        </UFormField>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <UFormField label="Departamento">
            <USelect
              v-model="state.departamento"
              :items="departamentos"
              placeholder="Selecione..."
              class="w-full"
            />
          </UFormField>

          <UFormField label="Tipo">
            <UInput v-model="state.tipo" disabled class="w-full" />
          </UFormField>

          <UFormField label="Localidade">
            <UInput
              v-model="state.localidade"
              placeholder="Ex: Bloco A, Sala 10"
              class="w-full"
            />
          </UFormField>

          <UFormField label="Categoria">
            <UInput v-model="state.categoria" disabled class="w-full" />
          </UFormField>

          <UFormField label="Ação" class="sm:col-start-2">
            <UInput v-model="state.acao" disabled class="w-full" />
          </UFormField>
        </div>
      </form>
    </template>

    <template #footer>
      <div class="flex w-full items-center justify-end gap-3">
        <UButton
          label="Cancelar"
          color="neutral"
          variant="ghost"
          @click="onCancel"
        />
        <UButton
          label="Abrir Chamado"
          color="primary"
          @click="onSubmit"
        />
      </div>
    </template>
  </UModal>
</template>
