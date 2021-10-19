import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  properties: []
}

// getters
export const getters = {
  properties: state => state.properties
}

// mutations
export const mutations = {
  [types.MUTATION_SET_ALL_PROPERTY] (state, properties) {
    state.properties = properties
  },

  [types.MUTATION_UPDATE_PROPERTY] (state, { index, property }) {
    state.properties[index] = property
  },

  [types.MUTATION_DELETE_PROPERTY] (state, index) {
    state.properties.splice(index, 1)
  },

  [types.MUTATION_CREATE_PROPERTY] (state, property) {
    state.properties.push(property);
  }
}

// actions
export const actions = {
  async getAllProperties ({ commit }) {
    try {
        const { data } = await axios.get('/api/propertynames')
        commit(types.MUTATION_SET_ALL_PROPERTY, data)
    } catch (e) { 

    }
  },

  async createProperty({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/propertynames', payload)
      commit(types.MUTATION_CREATE_PROPERTY, data)
    } catch (e) {

    }
  },

  async updateProperty ({ commit }, payload) {
    try {
        const { data } = await axios.patch('/api/propertynames/' + state.properties[payload.index].id, {propertyName: payload.propertyName})
        var newPayload = {
          index: payload.index,
          property: data
        }
        commit(types.MUTATION_UPDATE_PROPERTY, newPayload)
    } catch (e) { 

    }
  },

  async deleteProperty ({ commit }, index) {
    try {
      await axios.delete('/api/propertynames/' + state.properties[index].id);
      commit(types.MUTATION_DELETE_PROPERTY, index);
    } catch (e) {

    }
  }
}
