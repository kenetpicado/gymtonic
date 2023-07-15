import { watch } from 'vue'

export function calculateTotal (form, prices) {
  if (form.period && prices.length > 0) {
    const price = prices.find((price) => price.period == form.period)
    return price.value - form.discount
  }
  return 0
}

export function watchForPrices (form, services, prices) {
  watch(
    // Watch for service_id changes
    () => form.service_id,

    (value) => {
      // Get prices by service selected
      prices.value = services.find((service) => service.id == value).prices

      // Set same period if exists
      // If not, set the last period
      form.period = prices.value.find((price) => price.period == form.period)
        ? form.period
        : prices.value[prices.value.length - 1].period
    }, { immediate: true })
}

export function getAvatarUrl (name) {
  return `https://ui-avatars.com/api/?name=${name}&rounded=true&size=256&background=eef2ff&color=4f46e5`
}
