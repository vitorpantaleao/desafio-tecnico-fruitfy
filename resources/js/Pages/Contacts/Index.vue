<template>
  <Head title="Contatos - Gerenciar Contatos" />
  
  <AppLayout>
    <div class="min-h-screen bg-gray-50 py-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
          <div class="px-6 py-8">
            <div class="flex justify-between items-center mb-8">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Contatos</h1>
                <p class="mt-2 text-gray-600">Gerencie seus contatos de forma simples e eficiente</p>
              </div>
              <Link :href="route('contacts.create')">
                <AppButton variant="primary" size="lg" :icon="PlusIcon">
                  Novo Contato
                </AppButton>
              </Link>
            </div>

            <EmptyState
              v-if="contacts.data.length === 0"
              :icon="UserGroupIcon"
              title="Nenhum contato encontrado"
              description="Comece criando seu primeiro contato e organize suas informações de forma simples e eficiente!"
              action-text="Criar Primeiro Contato"
              :action-href="route('contacts.create')"
              :action-icon="PlusIcon"
            />

            <div v-else class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nome
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Email
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Telefone
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Ações
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10">
                          <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <UserIcon class="h-6 w-6 text-blue-600" />
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">{{ contact.name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ contact.email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ formatPhone(contact.phone) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                      <Link :href="route('contacts.show', contact.id)">
                        <AppButton variant="outline" size="sm" :icon="EyeIcon">
                          Ver
                        </AppButton>
                      </Link>
                      <Link :href="route('contacts.edit', contact.id)">
                        <AppButton variant="success" size="sm" :icon="PencilIcon">
                          Editar
                        </AppButton>
                      </Link>
                      <AppButton 
                        variant="danger" 
                        size="sm" 
                        :icon="TrashIcon"
                        @click="showDeleteConfirm(contact)"
                      >
                        Excluir
                      </AppButton>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Paginação -->
            <div v-if="contacts.links" class="mt-8 flex justify-center">
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <template v-for="(link, index) in contacts.links" :key="index">
                  <Link
                    v-if="link.url"
                    :href="link.url"
                    :class="[
                      'relative inline-flex items-center px-3 py-2 border text-sm font-medium transition-colors',
                      link.active
                        ? 'z-10 bg-blue-50 border-blue-500 text-blue-600'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                      index === 0 ? 'rounded-l-md' : '',
                      index === contacts.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    v-html="link.label"
                  />
                  <span
                    v-else
                    :class="[
                      'relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-300',
                      index === 0 ? 'rounded-l-md' : '',
                      index === contacts.links.length - 1 ? 'rounded-r-md' : '',
                    ]"
                    v-html="link.label"
                  />
                </template>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <ConfirmModal
      v-if="showConfirmModal"
      type="danger"
      title="Excluir Contato"
      :message="`Tem certeza que deseja excluir ${contactToDelete?.name}? Esta ação não pode ser desfeita.`"
      confirm-text="Excluir"
      cancel-text="Cancelar"
      @confirm="handleDeleteConfirm"
      @cancel="hideDeleteConfirm"
    />
  </AppLayout>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import { useNotifications } from '@/composables/useNotifications'
import AppLayout from '@/Layouts/AppLayout.vue'
import ConfirmModal from '@/Components/ConfirmModal.vue'
import AppButton from '@/Components/AppButton.vue'
import EmptyState from '@/Components/EmptyState.vue'
import { 
  PlusIcon, 
  UserGroupIcon, 
  UserIcon, 
  EyeIcon, 
  PencilIcon, 
  TrashIcon 
} from '@heroicons/vue/24/outline'

defineProps({
  contacts: Object,
})

const { success, error } = useNotifications()
const showConfirmModal = ref(false)
const contactToDelete = ref(null)

const formatPhone = (phone) => {
  if (!phone) return ''
  const cleaned = phone.replace(/\D/g, '')
  const match = cleaned.match(/^(\d{2})(\d{4,5})(\d{4})$/)
  if (match) {
    return `(${match[1]}) ${match[2]}-${match[3]}`
  }
  return phone
}

const showDeleteConfirm = (contact) => {
  contactToDelete.value = contact
  showConfirmModal.value = true
}

const hideDeleteConfirm = () => {
  showConfirmModal.value = false
  contactToDelete.value = null
}

const handleDeleteConfirm = () => {
  if (contactToDelete.value) {
    router.delete(route('contacts.destroy', contactToDelete.value.id), {
      onSuccess: () => {
        success('Contato Excluído', `${contactToDelete.value.name} foi excluído com sucesso.`)
        hideDeleteConfirm()
      },
      onError: () => {
        error('Erro na Exclusão', 'Ocorreu um erro ao excluir o contato. Tente novamente.')
        hideDeleteConfirm()
      }
    })
  }
}

// Mostrar mensagem de sucesso se redirecionado de create/update
onMounted(() => {
  const urlParams = new URLSearchParams(window.location.search)
  if (urlParams.get('created') === 'true') {
    success('Contato Criado', 'O contato foi criado com sucesso.')
  } else if (urlParams.get('updated') === 'true') {
    success('Contato Atualizado', 'O contato foi atualizado com sucesso.')
  }
})
</script> 