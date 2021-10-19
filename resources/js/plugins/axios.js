import axios from 'axios'
import store from '~/store'
import router from '~/router'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common.Authorization = `Bearer ${token}`
  }

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500 && !store.getters['auth/token']) {
    Swal.fire({
      icon: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
  }

  if (status === 401 && !store.getters['auth/token']) {
    Swal.fire({
      icon: 'warning',
      title: i18n.t('error_alert_title'),
      text: "Username or Password incorrect. Please try again.",
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    }).then(() => {
      // store.commit('auth/LOGOUT')

      // router.push({ name: 'login' })
    })
  }

  if (status === 400 && !store.getters['auth/token']) {
    var errorTxtArr = Object.values(JSON.parse(error.response.data));
    Swal.fire({
      icon: 'warning',
      title: i18n.t('error_alert_title'),
      text: errorTxtArr[0][0],
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    })
  }

  return Promise.reject(error)
})
