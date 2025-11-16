<template>
  <div class="card flight-card h-100">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-start mb-3">
        <h5 class="card-title mb-0">
          {{ flight.departure_airport.code }} - {{ flight.departure_airport.name }} ({{ flight.departure_airport.city }}) → {{ flight.arrival_airport.code }} - {{ flight.arrival_airport.name }} ({{ flight.arrival_airport.city }})
        </h5>
        <span class="badge bg-primary badge-airline">
          {{ flight.airline?.name || flight.airline_code }}
        </span>
      </div>

      <div class="mb-3">
        <div class="row">
          <div class="col-6">
            <small class="text-muted">Departure</small>
            <div class="fw-bold">{{ formatTime(flight.departure_at) }}</div>
            <small>{{ formatDate(flight.departure_at) }}</small>
          </div>
          <div class="col-6">
            <small class="text-muted">Arrival</small>
            <div class="fw-bold">{{ formatTime(flight.arrival_at) }}</div>
            <small>{{ formatDate(flight.arrival_at) }}</small>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <small class="text-muted">Flight Number</small>
        <div>{{ flight.airline_code }}{{ flight.number }}</div>
      </div>

      <hr>

      <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">${{ flight.price }}</h4>
        <button v-if="!hideBooking" @click="bookFlight"
                class="btn btn-success" :disabled="booking">
          <span v-if="booking">Booking...</span>
          <span v-else>Book Flight</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { api } from '../services/api.js'

const props = defineProps({
  flight: {
    type: Object,
    required: true
  },
  hideBooking: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['booking-success'])

const booking = ref(false)

const formatTime = (datetime) => {
  return new Date(datetime).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

const formatDate = (datetime) => {
  return new Date(datetime).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const bookFlight = async () => {
  const result = await Swal.fire({
    title: 'Confirm Booking',
    text: `Book flight for $${props.flight.price}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, book it!',
    cancelButtonText: 'Cancel'
  })

  if (!result.isConfirmed) return

  booking.value = true

  try {
    const response = await api.post('/book/trip', {
      flight_id: props.flight.id
    })

    if (response.data.success) {
      await Swal.fire('Success!', 'Flight booked successfully!', 'success')
      emit('booking-success')
    }
  } catch (error) {
    Swal.fire('Error', 'Failed to book flight', 'error')
  } finally {
    booking.value = false
  }
}
</script>
