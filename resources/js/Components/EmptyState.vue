<template>
  <div class="text-center py-12">
    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
      <component :is="icon" class="h-24 w-24" />
    </div>
    <h3 class="mt-2 text-lg font-medium text-gray-900">{{ title }}</h3>
    <p class="mt-1 text-sm text-gray-500 max-w-sm mx-auto">{{ description }}</p>
    <div v-if="actionText && actionHref" class="mt-6">
      <Link :href="actionHref">
        <AppButton :variant="actionVariant" :icon="actionIcon">
          {{ actionText }}
        </AppButton>
      </Link>
    </div>
    <div v-else-if="actionText" class="mt-6">
      <AppButton :variant="actionVariant" :icon="actionIcon" @click="$emit('action')">
        {{ actionText }}
      </AppButton>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppButton from './AppButton.vue'
import { UserGroupIcon } from '@heroicons/vue/24/outline'

defineProps({
  icon: {
    type: [String, Object],
    default: UserGroupIcon
  },
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  actionText: {
    type: String,
    default: ''
  },
  actionHref: {
    type: String,
    default: ''
  },
  actionVariant: {
    type: String,
    default: 'primary'
  },
  actionIcon: {
    type: [String, Object],
    default: null
  }
})

defineEmits(['action'])
</script> 