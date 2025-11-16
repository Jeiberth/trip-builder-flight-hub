<template>
  <div>
    <h3 class="mb-4">My Booked Trips</h3>

    <div v-if="trips.length === 0" class="alert alert-info">
      You haven't booked any trips yet.
    </div>

    <div v-else>
      <div v-for="trip in trips" :key="trip.id" class="mb-4">
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
              {{ trip.type === 'ONE_WAY' ? '✈️ One-Way Trip' : '✈️ Round Trip' }}
              <span class="float-end">Total: ${{ trip.total_price }}</span>
            </h5>
            <small>Booked on: {{ formatDateTime(trip.created_at) }}</small>
          </div>
          <div class="card-body">
            <div v-if="trip.type === 'ONE_WAY' && trip.trip_flights[0]">
              <OneWayTripCard
                :flight="trip.trip_flights[0].flight"
                :hide-booking="true" />
            </div>

            <div v-if="trip.type === 'ROUND_TRIP' && trip.trip_flights.length >= 2">
              <RoundTripCard
                :outbound="trip.trip_flights[0].flight"
                :return-flight="trip.trip_flights[1].flight"
                :hide-booking="true" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import OneWayTripCard from '../components/OneWayTripCard.vue'
import RoundTripCard from '../components/RoundTripCard.vue'

defineProps({
  trips: {
    type: Array,
    default: () => []
  }
})

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
