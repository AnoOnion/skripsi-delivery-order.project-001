import * as types from '../mutation-types'

// state
export const state = {
    products: []
}

// getters
export const getters = {
    products: state => state.products
}

// mutations
export const mutations = {
    [types.UPDATE_DATA_PRODUCT](state, { products }) {
        state.products = products
    }
}

// actions
export const actions = {
    saveDataProduct({ commit }, payload) {
        commit(types.UPDATE_DATA_PRODUCT, payload)
    }
}
