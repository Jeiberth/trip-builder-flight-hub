<template>
  <div>
    <SearchFlightContainer @search-results="handleSearchResults" />

    <!-- Results Section -->
    <div v-if="searchResults.length > 0" class="mt-5">
      <h3 class="mb-4">Available Flights</h3>

      <!-- One-way Results -->
      <div v-if="tripType === 'one_way'" class="row">
        <div class="col-md-6 mb-4" v-for="flight in searchResults" :key="flight.id">
          <OneWayTripCard :flight="flight" @booking-success="$emit('booking-success')" />
        </div>
      </div>

      <!-- Round-trip Results -->
      <div v-if="tripType === 'round_trip'" class="row">
        <div v-if="roundTripPairs.length === 0" class="col-12">
          <div class="alert alert-warning">
            No round-trip combinations found. Please adjust your search criteria.
          </div>
        </div>
        <div class="col-12 mb-4" v-for="pair in roundTripPairs"
             :key="pair.outbound.id + '-' + pair.return.id">
          <RoundTripCard
            :outbound="pair.outbound"
            :return-flight="pair.return"
            @booking-success="$emit('booking-success')" />
        </div>
      </div>
    </div>

    <div v-else-if="searchPerformed" class="alert alert-info mt-4">
      No flights found matching your criteria.
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import SearchFlightContainer from '../components/SearchFlightContainer.vue'
import OneWayTripCard from '../components/OneWayTripCard.vue'
import RoundTripCard from '../components/RoundTripCard.vue'

const props = defineProps({
  searchResults: Array,
  tripType: String,
  searchPerformed: Boolean,
  departureAt: String,
  returnAt: String
})

const emit = defineEmits(['search-results', 'booking-success'])

const debugInfo = ref(null)

// Helper function to extract date part in YYYY-MM-DD format (UTC)
const extractUTCDate = (dateString) => {
  const date = new Date(dateString)
  return date.toISOString().split('T')[0]
}

const roundTripPairs = computed(() => {
  if (props.tripType !== 'round_trip' || props.searchResults.length === 0) {
    debugInfo.value = null
    return []
  }

  // Extract UTC dates from search parameters
  const searchDepartureDateUTC = props.departureAt // Already in YYYY-MM-DD format
  const searchReturnDateUTC = props.returnAt // Already in YYYY-MM-DD format

  // Filter outbound flights (flights on departure date - UTC comparison)
  const outboundFlights = props.searchResults.filter(flight => {
    const flightDateUTC = extractUTCDate(flight.departure_at)
    const isOutbound = flightDateUTC === searchDepartureDateUTC
    return isOutbound
  })

  // Filter return flights (flights on return date - UTC comparison)
  const returnFlights = props.searchResults.filter(flight => {
    const flightDateUTC = extractUTCDate(flight.departure_at)
    const isReturn = flightDateUTC === searchReturnDateUTC
    return isReturn
  })

  // Create all possible combinations
  const pairs = []
  outboundFlights.forEach(outbound => {
    returnFlights.forEach(returnFlight => {
      pairs.push({
        outbound: outbound,
        return: returnFlight
      })
    })
  })


  // Collect all flight dates for debugging
  const allFlightDates = props.searchResults.map(flight => ({
    id: flight.id,
    departure: flight.departure_at,
    utcDate: extractUTCDate(flight.departure_at),
    localDate: new Date(flight.departure_at).toDateString()
  }))

  // Set debug info for display
  debugInfo.value = {
    outboundCount: outboundFlights.length,
    returnCount: returnFlights.length,
    departureDate: searchDepartureDateUTC,
    returnDate: searchReturnDateUTC,
    allFlightDates: allFlightDates.map(f => `Flight ${f.id}: ${f.utcDate} (local: ${f.localDate})`).join(', ')
  }

  return pairs
})

const handleSearchResults = (data) => {
  emit('search-results', data)
}
</script>
