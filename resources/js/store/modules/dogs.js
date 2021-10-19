import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  dogs: [],
  dogperformance: null
}

// getters
export const getters = {
  dogs: state => state.dogs,
  dogperformance: state => state.dogperformance
}

// mutations
export const mutations = {
  [types.MUTATION_SET_ALL_DOG] (state, dogs) {
    state.dogs = dogs
  },

  [types.MUTATION_UPDATE_DOG] (state, { index, dog }) {
    for (var i = 0; i < state.dogs.length; i++) {
      if (state.dogs[i].id == index) state.dogs[i] = dog
    }
  },

  [types.MUTATION_DELETE_DOG] (state, index) {
    for (var i = 0; i < state.dogs.length; i++) {
      if (state.dogs[i].id == index) state.dogs.splice(i, 1)
    }  
  },

  [types.MUTATION_CREATE_DOG] (state, dog) {
    state.dogs.push(dog);
  },

  [types.MUTATION_SET_DOGPERFORMANCE] (state, dogperformance) {
      state.dogperformance = dogperformance
  }
}

// actions
export const actions = {
  async getAllDogs ({ commit }) {
    try {
        const { data } = await axios.get('/api/dognames')
        commit(types.MUTATION_SET_ALL_DOG, data)
    } catch (e) { 

    }
  },

  async createDog({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/dognames', payload)
      commit(types.MUTATION_CREATE_DOG, data)
    } catch (e) {

    }
  },

  async updateDog ({ commit }, payload) {
    try {
        const { data } = await axios.patch('/api/dognames/' + payload.index, {dogName: payload.dogName})
        var newPayload = {
          index: payload.index,
          dog: data
        }
        commit(types.MUTATION_UPDATE_DOG, newPayload)
    } catch (e) { 

    }
  },

  async deleteDog ({ commit }, index) {
    try {
      await axios.delete('/api/dognames/' + index);
      commit(types.MUTATION_DELETE_DOG, index);
    } catch (e) {

    }
  },

  async getDogPerformance({ commit }) {
    try {
        const { data } = await axios.get('/api/getDogPerformance')
        commit(types.MUTATION_SET_DOGPERFORMANCE, data)
    } catch (e) { 

    }
  }
}
