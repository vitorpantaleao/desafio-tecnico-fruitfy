import { reactive } from 'vue'

const state = reactive({
  notifications: []
})

let notificationId = 0

export function useNotifications() {
  const addNotification = (notification) => {
    const id = ++notificationId
    const newNotification = {
      id,
      ...notification
    }
    
    state.notifications.push(newNotification)
    
    return id
  }

  const removeNotification = (id) => {
    const index = state.notifications.findIndex(n => n.id === id)
    if (index > -1) {
      state.notifications.splice(index, 1)
    }
  }

  const success = (title, message, duration = 4000) => {
    return addNotification({
      type: 'success',
      title,
      message,
      duration
    })
  }

  const error = (title, message, duration = 5000) => {
    return addNotification({
      type: 'error',
      title,
      message,
      duration
    })
  }

  const warning = (title, message, duration = 4000) => {
    return addNotification({
      type: 'warning',
      title,
      message,
      duration
    })
  }

  const info = (title, message, duration = 4000) => {
    return addNotification({
      type: 'info',
      title,
      message,
      duration
    })
  }

  const clear = () => {
    state.notifications.splice(0)
  }

  return {
    notifications: state.notifications,
    addNotification,
    removeNotification,
    success,
    error,
    warning,
    info,
    clear
  }
} 