import axios from 'axios'

// Criar instância base do Axios
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8088/api',
  headers: {
    'Content-Type': 'application/json',
  }
})

export default apiClient
