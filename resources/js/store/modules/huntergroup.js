import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  huntergroups: []
}

// getters
export const getters = {
  huntergroups: state => state.huntergroups
}

// mutations
export const mutations = {
  [types.MUTATION_SET_ALL_HUNTERGROUP] (state, huntergroup) {
    state.huntergroups = huntergroup
  },

  [types.MUTATION_UPDATE_HUNTERGROUP] (state, { index, huntergroup }) {
    for (var i = 0; i < state.huntergroups.length; i++) {
      if (state.huntergroups[i].id == index) state.huntergroups[i] = huntergroup
    }
  },

  [types.MUTATION_DELETE_HUNTERGROUP] (state, index) {
    for (var i = 0; i < state.huntergroups.length; i++) {
      if (state.huntergroups[i].id == index) state.huntergroups.splice(i, 1)
    }    
  },

  [types.MUTATION_CREATE_HUNTERGROUP] (state, huntergroup) {
    state.huntergroups.push(huntergroup);
  }
}

// actions
export const actions = {
  async getAllHuntergroups ({ commit }) {
    try {
        const { data } = await axios.get('/api/huntergroup')
        commit(types.MUTATION_SET_ALL_HUNTERGROUP, data)
    } catch (e) { 

    }
  },

  async createHuntergroup({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/huntergroup', payload)
      commit(types.MUTATION_CREATE_HUNTERGROUP, data)
    } catch (e) {

    }
  },

  async updateHuntergroup ({ commit }, payload) {
    try {
        const { data } = await axios.patch('/api/huntergroup/' + payload.index, {groupName: payload.groupName})
        var newPayload = {
          index: payload.index,
          huntergroup: data
        }
        commit(types.MUTATION_UPDATE_HUNTERGROUP, newPayload)
    } catch (e) { 

    }
  },

  async deleteHuntergroup ({ commit }, index) {
    try {
      await axios.delete('/api/huntergroup/' + index);
      commit(types.MUTATION_DELETE_HUNTERGROUP, index);
    } catch (e) {

    }
  },
}
