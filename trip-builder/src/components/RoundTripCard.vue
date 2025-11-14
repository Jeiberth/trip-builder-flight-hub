<template>
  <div class="card flight-card">
    <div class="card-body">
      <h5 class="card-title mb-4">Round Trip</h5>

      <!-- Outbound Flight -->
      <div class="mb-4 p-3 bg-light rounded">
        <h6 class="text-primary mb-3">✈️ Outbound Flight</h6>
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <!-- <h5 class="mb-0">{{ outbound.departure_airport }} → {{ outbound.arrival_airport }}</h5> -->
            <h5 class="mb-0">{{ outbound.departure_airport.code }} - {{ outbound.departure_airport.name }} ({{ outbound.departure_airport.city }}) → {{ outbound.arrival_airport.code }} - {{ outbound.arrival_airport.name }} ({{ outbound.arrival_airport.city }})</h5>
            <small class="text-muted">{{ outbound.airline?.name || outbound.airline_code }}{{ outbound.number }}</small>
          </div>
          <span class="badge bg-primary">{{ outbound.airline?.name || outbound.airline_code }}</span>
        </div>
        <div class="row">
          <div class="col-6">
            <small class="text-muted">Departure</small>
            <div class="fw-bold">{{ formatTime(outbound.departure_at) }}</div>
            <small>{{ formatDate(outbound.departure_at) }}</small>
          </div>
          <div class="col-6">
            <small class="text-muted">Arrival</small>
            <div class="fw-bold">{{ formatTime(outbound.arrival_at) }}</div>
            <small>{{ formatDate(outbound.arrival_at) }}</small>
          </div>
        </div>
        <div class="mt-2">
          <strong>Price: ${{ outbound.price }}</strong>
        </div>
      </div>

      <!-- Return Flight -->
      <div class="mb-3 p-3 bg-light rounded">
        <h6 class="text-success mb-3">🔄 Return Flight</h6>
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <!-- <h5 class="mb-0">{{ returnFlight.departure_airport }} → {{ returnFlight.arrival_airport }}</h5> -->
            <h5 class="mb-0">{{ returnFlight.departure_airport.code }} - {{ returnFlight.departure_airport.name }} ({{ returnFlight.departure_airport.city }}) → {{ returnFlight.arrival_airport.code }} - {{ returnFlight.arrival_airport.name }} ({{ returnFlight.arrival_airport.city }})</h5>
            <small class="text-muted">{{ returnFlight.airline?.name || returnFlight.airline_code }}{{ returnFlight.number }}</small>
          </div>
          <span class="badge bg-success">{{ returnFlight.airline?.name || returnFlight.airline_code }}</span>
        </div>
        <div class="row">
          <div class="col-6">
            <small class="text-muted">Departure</small>
            <div class="fw-bold">{{ formatTime(returnFlight.departure_at) }}</div>
            <small>{{ formatDate(returnFlight.departure_at) }}</small>
          </div>
          <div class="col-6">
            <small class="text-muted">Arrival</small>
            <div class="fw-bold">{{ formatTime(returnFlight.arrival_at) }}</div>
            <small>{{ formatDate(returnFlight.arrival_at) }}</small>
          </div>
        </div>
        <div class="mt-2">
          <strong>Price: ${{ returnFlight.price }}</strong>
        </div>
      </div>

      <hr>

      <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-primary mb-0">Total: ${{ totalPrice }}</h4>
        <button v-if="!hideBooking" @click="bookTrip"
                class="btn btn-success btn-lg" :disabled="booking">
          <span v-if="booking">Booking...</span>
          <span v-else>Book Round Trip</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { api } from '../services/api.js'

const props = defineProps({
  outbound: {
    type: Object,
    required: true
  },
  returnFlight: {
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

const totalPrice = computed(() => {
  return (parseFloat(props.outbound.price) + parseFloat(props.returnFlight.price)).toFixed(2)
})

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

const bookTrip = async () => {
  const result = await Swal.fire({
    title: 'Confirm Booking',
    text: `Book round trip for $${totalPrice.value}?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, book it!',
    cancelButtonText: 'Cancel'
  })

  if (!result.isConfirmed) return

  booking.value = true

  try {
    const response = await api.post('/book/trip', {
      flight_id: props.outbound.id,
      return_flight_id: props.returnFlight.id
    })

    if (response.data.success) {
      await Swal.fire('Success!', 'Round trip booked successfully!', 'success')
      emit('booking-success')
    }
  } catch (error) {
    Swal.fire('Error', 'Failed to book trip', 'error')
  } finally {
    booking.value = false
  }
}
</script>
