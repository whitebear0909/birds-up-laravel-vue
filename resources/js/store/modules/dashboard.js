import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  dashboard: null,
  mapcovey: null
}

// getters
export const getters = {
  dashboard: state => state.dashboard,
  mapcovey: state => state.mapcovey
}

// mutations
export const mutations = {
  [types.MUTATION_SET_DASHBOARD] (state, dashboard) {
    state.dashboard = dashboard
  },

  [types.MUTATION_SET_MAPCOVEY] (state, mapcovey) {
    state.mapcovey = mapcovey
  }
}

// actions
export const actions = {
  async getDashboard ({ commit }) {
    try {
        const { data } = await axios.get('/api/getDashboard')
        commit(types.MUTATION_SET_DASHBOARD, data)
    } catch (e) { 

    }
  },

  async getMapCovey({ commit }, query) {
    try {
      const { data } = await axios.get('/api/getMapCovey' + query)
      commit(types.MUTATION_SET_MAPCOVEY, data)
    } catch (e) {

    }
  }
}
