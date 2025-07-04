<template>
  <Head :title="`${contact.name} - Detalhes do Contato`" />
  
  <AppLayout>
    <div class="min-h-screen bg-gray-50 py-6">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
          <div class="px-6 py-8">
            <div class="flex justify-between items-center mb-8">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Detalhes do Contato</h1>
                <p class="mt-2 text-gray-600">Informações completas do contato</p>
              </div>
              <div class="flex space-x-3">
                <Link :href="route('contacts.edit', contact.id)">
                  <AppButton variant="success" :icon="PencilIcon">
                    Editar
                  </AppButton>
                </Link>
                <Link :href="route('contacts.index')">
                  <AppButton variant="secondary" :icon="ArrowLeftIcon">
                    Voltar
                  </AppButton>
                </Link>
              </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-8">
              <div class="flex items-center mb-6">
                <div class="flex-shrink-0 h-16 w-16">
                  <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <UserIcon class="h-8 w-8 text-blue-600" />
                  </div>
                </div>
                <div class="ml-6">
                  <h2 class="text-2xl font-bold text-gray-900">{{ contact.name }}</h2>
                  <p class="text-gray-600">Contato</p>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
              <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                  <UserIcon class="h-5 w-5 text-gray-400 mr-2" />
                  <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Nome</label>
                </div>
                <p class="text-lg text-gray-900 font-medium">{{ contact.name }}</p>
              </div>

              <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                  <EnvelopeIcon class="h-5 w-5 text-gray-400 mr-2" />
                  <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email</label>
                </div>
                <p class="text-lg text-gray-900">
                  <a :href="`mailto:${contact.email}`" class="text-blue-600 hover:text-blue-800 transition-colors">
                    {{ contact.email }}
                  </a>
                </p>
              </div>

              <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                  <PhoneIcon class="h-5 w-5 text-gray-400 mr-2" />
                  <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Telefone</label>
                </div>
                <p class="text-lg text-gray-900">
                  <a :href="`tel:${contact.phone}`" class="text-blue-600 hover:text-blue-800 transition-colors">
                    {{ formatPhone(contact.phone) }}
                  </a>
                </p>
              </div>

              <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                  <CalendarIcon class="h-5 w-5 text-gray-400 mr-2" />
                  <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Criado em</label>
                </div>
                <p class="text-lg text-gray-900">{{ formatDate(contact.created_at) }}</p>
              </div>

              <div class="bg-white border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-2">
                  <ClockIcon class="h-5 w-5 text-gray-400 mr-2" />
                  <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Atualizado em</label>
                </div>
                <p class="text-lg text-gray-900">{{ formatDate(contact.updated_at) }}</p>
              </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end">
              <AppButton
                variant="danger"
                :icon="TrashIcon"
                @click="showDeleteConfirm"
              >
                Excluir Contato
              </AppButton>
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
      :message="`Tem certeza que deseja excluir ${contact.name}? Esta ação não pode ser desfeita.`"
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
import { ref } from 'vue'
import { useNotifications } from '@/composables/useNotifications'
import AppLayout from '@/Layouts/AppLayout.vue'
import ConfirmModal from '@/Components/ConfirmModal.vue'
import AppButton from '@/Components/AppButton.vue'
import { 
  ArrowLeftIcon, 
  UserIcon, 
  EnvelopeIcon, 
  PhoneIcon, 
  PencilIcon, 
  TrashIcon, 
  CalendarIcon, 
  ClockIcon 
} from '@heroicons/vue/24/outline'

const props = defineProps({
  contact: Object,
})

const { success, error } = useNotifications()
const showConfirmModal = ref(false)

const formatPhone = (phone) => {
  if (!phone) return ''
  const cleaned = phone.replace(/\D/g, '')
  const match = cleaned.match(/^(\d{2})(\d{4,5})(\d{4})$/)
  if (match) {
    return `(${match[1]}) ${match[2]}-${match[3]}`
  }
  return phone
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('pt-BR', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}

const showDeleteConfirm = () => {
  showConfirmModal.value = true
}

const hideDeleteConfirm = () => {
  showConfirmModal.value = false
}

const handleDeleteConfirm = () => {
  router.delete(route('contacts.destroy', props.contact.id), {
    onSuccess: () => {
      success('Contato Excluído', `${props.contact.name} foi excluído com sucesso.`)
      // Redirecionar para o índice após um pequeno delay para mostrar a notificação
      setTimeout(() => {
        router.visit(route('contacts.index'))
      }, 1000)
    },
    onError: () => {
      error('Erro na Exclusão', 'Ocorreu um erro ao excluir o contato. Tente novamente.')
      hideDeleteConfirm()
    }
  })
}
</script> 