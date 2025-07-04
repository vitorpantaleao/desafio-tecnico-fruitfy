<template>
  <Head :title="`Editar ${contact.name} - Editar Contato`" />
  
  <AppLayout>
    <div class="min-h-screen bg-gray-50 py-6">
      <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg">
          <div class="px-6 py-8">
            <div class="flex justify-between items-center mb-8">
              <div>
                <h1 class="text-3xl font-bold text-gray-900">Editar Contato</h1>
                <p class="mt-2 text-gray-600">Atualize as informações do contato</p>
              </div>
              <Link :href="route('contacts.index')">
                <AppButton variant="secondary" :icon="ArrowLeftIcon">
                  Voltar
                </AppButton>
              </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
              <div class="grid grid-cols-1 gap-6">
                <FormInput
                  id="name"
                  v-model="form.name"
                  label="Nome"
                  placeholder="Digite o nome completo"
                  :error="form.errors.name"
                  :icon="UserIcon"
                  required
                />

                <FormInput
                  id="email"
                  v-model="form.email"
                  type="email"
                  label="Email"
                  placeholder="Digite o endereço de email"
                  :error="form.errors.email"
                  :icon="EnvelopeIcon"
                  required
                />

                <FormInput
                  id="phone"
                  v-model="form.phone"
                  type="tel"
                  label="Telefone"
                  placeholder="Digite o número de telefone"
                  :error="form.errors.phone"
                  :icon="PhoneIcon"
                  help="Formato: (11) 99999-9999"
                  required
                />
              </div>

              <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <Link :href="route('contacts.index')">
                  <AppButton variant="outline" :icon="XMarkIcon">
                    Cancelar
                  </AppButton>
                </Link>
                <AppButton
                  type="submit"
                  variant="primary"
                  :loading="form.processing"
                  :icon="CheckIcon"
                >
                  {{ form.processing ? 'Salvando...' : 'Salvar Alterações' }}
                </AppButton>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { Head } from '@inertiajs/vue3'
import { useNotifications } from '@/composables/useNotifications'
import AppLayout from '@/Layouts/AppLayout.vue'
import FormInput from '@/Components/FormInput.vue'
import AppButton from '@/Components/AppButton.vue'
import { 
  ArrowLeftIcon, 
  UserIcon, 
  EnvelopeIcon, 
  PhoneIcon, 
  XMarkIcon, 
  CheckIcon 
} from '@heroicons/vue/24/outline'

const props = defineProps({
  contact: Object,
})

const { error } = useNotifications()

const form = useForm({
  name: props.contact.name,
  email: props.contact.email,
  phone: props.contact.phone,
})

const submit = () => {
  form.put(route('contacts.update', props.contact.id), {
    onSuccess: () => {
      // Redirecionar para o índice com parâmetro de sucesso
      router.visit(route('contacts.index') + '?updated=true')
    },
    onError: () => {
      error('Erro de Validação', 'Verifique os campos do formulário e tente novamente.')
    }
  })
}
</script> 