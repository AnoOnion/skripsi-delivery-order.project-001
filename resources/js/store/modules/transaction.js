import * as types from '../mutation-types'

// state
export const state = {
    history: []
}

// getters
export const getters = {
    history: state => state.history
}

// mutations
export const mutations = {
    [types.FETCH_HISTORY](state, { history }) {
        state.history = history
    }
}

// actions
export const actions = {
    saveHistory({ commit }, payload) {
        commit(types.FETCH_HISTORY, payload)
    }
}
