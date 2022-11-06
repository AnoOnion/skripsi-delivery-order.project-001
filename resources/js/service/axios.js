import axios from 'axios'
import store from '~/store'

axios.defaults.baseURL = 'https://skripsi.project-001.anoonion.xyz/'

axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']

    if (token) {
        request.headers.common['Authorization'] = `Bearer ${token}`
    }

    return request
})
