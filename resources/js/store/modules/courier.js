import * as types from '../mutation-types'

// state
export const state = {
    courier: [],

    taker: {
        user: {
            nama_depan: null,
            nama_belakang: '',
            avatar: 'https://www.gravatar.com/avatar/1667f76cd188f63e4c39792bb4357838?d=mm&s=40'
        },
        vehicle: null,
        location: null,
        distance: 0
    }
}

// getters
export const getters = {
    courier: state => state.courier,
    taker: state => state.taker
}

// mutations
export const mutations = {
    [types.UPDATE_DATA_COURIER](state, { courier }) {
        state.courier = courier
    },

    [types.UPDATE_DATA_TAKER](state, { user, vehicle, location, distance }) {
        state.taker.user = user
        state.taker.vehicle = vehicle
        state.taker.location = location
        state.taker.distance = distance
    }
}

// actions
export const actions = {
    saveDataCourier({ commit }, payload) {
        commit(types.UPDATE_DATA_COURIER, payload)
    },

    saveDataTaker({ commit }, payload) {
        commit(types.UPDATE_DATA_TAKER, payload)
    }
}
