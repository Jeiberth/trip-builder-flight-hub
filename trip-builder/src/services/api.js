import axios from 'axios'

const API_URL = 'http://localhost:8000/api' // Change this to your Laravel API URL

export const api = axios.create({
  baseURL: API_URL
})

// You can also add interceptors here if needed
api.interceptors.response.use(
  response => response,
  error => {
    console.error('API Error:', error)
    return Promise.reject(error)
  }
)
