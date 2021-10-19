import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  courses: [],
  coursemetrics: null
}

// getters
export const getters = {
  courses: state => state.courses,
  coursemetrics: state => state.coursemetrics
}

// mutations
export const mutations = {
  [types.MUTATION_SET_ALL_COURSE] (state, courses) {
    state.courses = courses
  },

  [types.MUTATION_UPDATE_COURSE] (state, { index, course }) {
    for (var i = 0; i < state.courses.length; i++) {
      if (state.courses[i].id == index) state.courses[i] = course
    }
  },

  [types.MUTATION_DELETE_COURSE] (state, index) {
    for (var i = 0; i < state.courses.length; i++) {
      if (state.courses[i].id == index) state.courses.splice(i, 1)
    }    
  },

  [types.MUTATION_CREATE_COURSE] (state, course) {
    state.courses.push(course);
  },

  [types.MUTATION_SET_COURSEMETRICS] (state, coursemetrics) {
    state.coursemetrics = coursemetrics
  }
}

// actions
export const actions = {
  async getAllCourses ({ commit }) {
    try {
        const { data } = await axios.get('/api/coursenames')
        commit(types.MUTATION_SET_ALL_COURSE, data)
    } catch (e) { 

    }
  },

  async createCourse({ commit }, payload) {
    try {
      const { data } = await axios.post('/api/coursenames', payload)
      commit(types.MUTATION_CREATE_COURSE, data)
    } catch (e) {

    }
  },

  async updateCourse ({ commit }, payload) {
    try {
        const { data } = await axios.patch('/api/coursenames/' + payload.index, {courseName: payload.courseName})
        var newPayload = {
          index: payload.index,
          course: data
        }
        commit(types.MUTATION_UPDATE_COURSE, newPayload)
    } catch (e) { 

    }
  },

  async deleteCourse ({ commit }, index) {
    try {
      await axios.delete('/api/coursenames/' + index);
      commit(types.MUTATION_DELETE_COURSE, index);
    } catch (e) {

    }
  },

  async getCourseMetrics ({ commit }, query) {
    try {
        const { data } = await axios.get('/api/getCourseMetrics' + query)
        commit(types.MUTATION_SET_COURSEMETRICS, data)
    } catch (e) { 

    }
  },
}
