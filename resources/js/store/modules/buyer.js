import * as types from '../mutation-types'

// state
export const state = {
    user: [],

    asset: {
        saldo: 0,
        kupon: 0
    },

    payment: {
        id: null,
        kode_pembayaran: null,
        total_tx: 0,
        status_bayar: 'belum'
    }
}

// getters
export const getters = {
    user: state => state.user,
    asset: state => state.asset,
    payment: state => state.payment
}

// mutations
export const mutations = {
    [types.UPDATE_DATA_BUYER](state, { user }) {
        state.user = user
    },

    [types.SAVE_PAYMENT](state, { asset, payment }) {
        state.asset = asset
        state.payment = payment
    }
}

// actions
export const actions = {
    saveDataBuyer({ commit }, payload) {
        commit(types.UPDATE_DATA_BUYER, payload)
    },

    savePayment({ commit }, payload) {
        commit(types.SAVE_PAYMENT, payload)
    }
}
