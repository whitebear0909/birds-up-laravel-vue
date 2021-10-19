import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit, faTrashAlt, faSave } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faEdit, faTrashAlt, faSave)

Vue.component('font-awesome-icon', FontAwesomeIcon)
