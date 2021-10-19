import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  hunters: []
}

// getters
export const getters = {
  hunters: state => state.hunters
}

// mutations
export const mutations = {
  [types.MUTATION_SET_ALL_HUNTER] (state, hunters) {
    state.hunters = hunters
  },

  [types.MUTATION_UPDATE_HUNTER] (state, { index, hunter }) {
    for (var i = 0; i < state.hunters.length; i++) {
      if (state.hunters[i].id == index) state.hunters[i] = hunter
    }
  },

  [types.MUTATION_DELETE_HUNTER] (state, index) {
    for (var i = 0; i < state.hunters.length; i++) {
      if (state.hunters[i].id == index) state.hunters.splice(i, 1)
    }    
  },

  [types.MUTATION_CREATE_HUNTER] (state, hunter) {
    state.hunters.push(hunter);
  }
}

// actions
export const actions = {
  async getAllHunters ({ commit }) {
    try {
        const { data } = await axios.get('/api/hunternames')
        commit(types.MUTATION_SET_ALL_HUNTER, data)
    } catch (e) { 

    }
  },

  async createHunter({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/hunternames', payload)
      commit(types.MUTATION_CREATE_HUNTER, data)
    } catch (e) {

    }
  },

  async updateHunter ({ commit }, payload) {
    try {
        const { data } = await axios.patch('/api/hunternames/' + payload.index, {hunterName: payload.hunterName})
        var newPayload = {
          index: payload.index,
          hunter: data
        }
        commit(types.MUTATION_UPDATE_HUNTER, newPayload)
    } catch (e) { 

    }
  },

  async deleteHunter ({ commit }, index) {
    try {
      await axios.delete('/api/hunternames/' + index);
      commit(types.MUTATION_DELETE_HUNTER, index);
    } catch (e) {

    }
  },
}
