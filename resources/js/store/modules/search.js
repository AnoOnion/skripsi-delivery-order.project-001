import * as types from '../mutation-types'

// state
export const state = {
    search: []
}

// getters
export const getters = {
    search: state => state.search
}

// mutations
export const mutations = {
    [types.SAVE_DATA_SEARCH](state, search) {
        state.search = search
    }
}

// actions
export const actions = {
    saveDataSearch({ commit }, payload) {
        commit(types.SAVE_DATA_SEARCH, payload)
    }
}
