<template>
  <div id="app">
    <nav class="navbar navbar-dark bg-primary mb-4">
      <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">✈️ Trip Builder</span>
      </div>
    </nav>

    <div class="container">
      <!-- Tabs -->
      <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link" :class="{ active: activeTab === 'search' }"
                  @click="activeTab = 'search'" type="button">
            🔍 Search Flights
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" :class="{ active: activeTab === 'trips' }"
                  @click="activeTab = 'trips'; loadTrips()" type="button">
            📋 My Trips
          </button>
        </li>
      </ul>

      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Search Flights Tab -->
        <SearchPage
          v-show="activeTab === 'search'"
          :search-results="searchResults"
          :trip-type="tripType"
          :search-performed="searchPerformed"
          :departure-at="departureAt"
          :return-at="returnAt"
          @search-results="handleSearchResults"
          @booking-success="handleBookingSuccess"
        />

        <!-- My Trips Tab -->
        <TripsPage
          v-show="activeTab === 'trips'"
          :trips="trips"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import SearchPage from './pages/SearchPage.vue'
import TripsPage from './pages/TripsPage.vue'
import { api } from './services/api.js'

const activeTab = ref('search')
const searchResults = ref([])
const tripType = ref('one_way')
const trips = ref([])
const searchPerformed = ref(false)
const departureAt = ref('')
const returnAt = ref('')

const handleSearchResults = (data) => {
  searchResults.value = data.flights
  tripType.value = data.tripType
  departureAt.value = data.departureAt
  returnAt.value = data.returnAt
  searchPerformed.value = true
}

const loadTrips = async () => {
  try {
    const response = await api.get('/trips')
    trips.value = response.data
  } catch (error) {
    Swal.fire('Error', 'Failed to load trips', 'error')
  }
}

const handleBookingSuccess = () => {
  Swal.fire({
    title: 'Success!',
    text: 'Would you like to view your trips?',
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: 'View Trips',
    cancelButtonText: 'Continue Searching'
  }).then((result) => {
    if (result.isConfirmed) {
      activeTab.value = 'trips'
      loadTrips()
    }
  })
}

const formatDateTime = (datetime) => {
  return new Date(datetime).toLocaleString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>

<style scoped>
@import './assets/styles.css';
</style>
