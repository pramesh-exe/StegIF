import axios from 'axios'

export default (app) => {
    app.config.globalProperties.$axios = axios.create({
        baseURL: 'http://localhost:8000',
    })
}

