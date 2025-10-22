import axios from 'axios'

const request = axios.create({
  baseURL: '',
  timeout: 10000,
})

request.interceptors.response.use(
  response => response,
  error => {
    const { response, request, message } = error

    if (response) {
      console.error(`[Axios Error] ${response.status}: ${response.data?.error || message}`)
      alert(`Error ${response.status}: ${response.data?.error || 'Server error'}`)
    } else if (request) {
      console.error('[Axios Error] No response from server')
      alert('No response from server. Please check your network or try again later.')
    } else {
      console.error('[Axios Error] Request setup failed:', message)
      alert('Request error: ' + message)
    }

    return Promise.reject(error)
  }
)

export default request
