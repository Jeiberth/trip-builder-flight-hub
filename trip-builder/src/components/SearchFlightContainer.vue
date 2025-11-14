<template>
  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Search Flights</h4>
    </div>
    <div class="card-body">
      <form @submit.prevent="searchFlights">
        <!-- Trip Type -->
        <div class="mb-3">
          <label class="form-label">Trip Type</label>
          <select v-model="tripType" class="form-select" required>
            <option value="one_way">One Way</option>
            <option value="round_trip">Round Trip</option>
          </select>
        </div>

        <div class="row">
          <!-- Departure Airport -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Departure Airport</label>
            <select v-model="departureAirport" class="form-select" required>
              <option value="">Select airport...</option>
              <option v-for="airport in airports" :key="airport.code" :value="airport.code">
                {{ airport.code }} - {{ airport.name }} ({{ airport.city }})
              </option>
            </select>
          </div>

          <!-- Arrival Airport -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Arrival Airport</label>
            <select v-model="arrivalAirport" class="form-select" required>
              <option value="">Select airport...</option>
              <option v-for="airport in airports" :key="airport.code" :value="airport.code">
                {{ airport.code }} - {{ airport.name }} ({{ airport.city }})
              </option>
            </select>
          </div>
        </div>

        <div class="row">
          <!-- Departure Date -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Departure Date</label>
            <input type="date" v-model="departureAt" class="form-control" required>
          </div>

          <!-- Return Date (only for round trip) -->
          <div class="col-md-6 mb-3" v-if="tripType === 'round_trip'">
            <label class="form-label">Return Date</label>
            <input type="date" v-model="returnAt" class="form-control" required>
          </div>
        </div>

        <!-- Airline Filter -->
        <div class="mb-3">
          <label class="form-label">Airline (Optional)</label>
          <select v-model="airline" class="form-select">
            <option value="">All Airlines</option>
            <option v-for="al in airlines" :key="al.code" :value="al.code">
              {{ al.name }} ({{ al.code }})
            </option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100" :disabled="loading">
          <span v-if="loading">Searching...</span>
          <span v-else>🔍 Search Flights</span>
        </button>
      </form>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from '../services/api.js'

const emit = defineEmits(['search-results'])

const tripType = ref('one_way')
const departureAirport = ref('')
const arrivalAirport = ref('')
const departureAt = ref('')
const returnAt = ref('')
const airline = ref('')
const airports = ref([])
const airlines = ref([])
const loading = ref(false)

const loadAirports = async () => {
  try {
    const response = await api.get('/airports')
    airports.value = response.data
  } catch (error) {
    Swal.fire('Error', 'Failed to load airports', 'error')
  }
}

const loadAirlines = async () => {
  try {
    const response = await api.get('/airlines')
    airlines.value = response.data
  } catch (error) {
    Swal.fire('Error', 'Failed to load airlines', 'error')
  }
}

const searchFlights = async () => {
  loading.value = true

  try {
    const params = {
      departure_airport: departureAirport.value,
      arrival_airport: arrivalAirport.value,
      departure_at: departureAt.value
    }

    if (tripType.value === 'round_trip') {
      params.return_at = returnAt.value
    }

    if (airline.value) {
      params.airline = airline.value
    }

    console.log('=== SEARCH PARAMS ===', params)

    const response = await api.get('/flights', { params })

    console.log('=== SEARCH RESULTS ===', response.data)

    emit('search-results', {
      flights: response.data,
      tripType: tripType.value,
      departureAt: departureAt.value,
      returnAt: returnAt.value
    })
  } catch (error) {
    Swal.fire('Error', 'Failed to search flights', 'error')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadAirports()
  loadAirlines()
})
</script>
