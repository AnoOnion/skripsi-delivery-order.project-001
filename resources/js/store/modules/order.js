import * as types from '../mutation-types'

// state
export const state = {
    orderStatus: false,
    deliveryStatus: 'offline',

    order: {
        user: null,
        items: []
    },

    location: {
        latitude: null,
        longitude: null,
        alamat_lengkap: null
    },

    courier: {
        id: null,
        cost: 1000
    }
}

// getters
export const getters = {
    orderStatus: state => state.orderStatus,
    deliveryStatus: state => state.deliveryStatus,
    order: state => state.order,
    location: state => state.location,
    courier: state => state.courier
}

// mutations
export const mutations = {
    [types.ADD_EVENT_ORDER](state, { orderStatus, deliveryStatus }) {
        state.orderStatus    = orderStatus
        state.deliveryStatus = deliveryStatus
    },

    [types.SAVE_ORDER](state, { user, items }) {
        state.order.user = user
        state.order.items  = items
    },

    [types.SAVE_ORDER_LOCATION](state, { latitude, longitude, alamat_lengkap }) {
        state.location.latitude = latitude
        state.location.longitude = longitude
        state.location.alamat_lengkap = alamat_lengkap
    },

    [types.SAVE_COURIER_ACTIVE](state, { id, cost }) {
        state.courier.id = id
        state.courier.cost = cost
    }
}

// actions
export const actions = {
    eventOrder({ commit }, payload) {
        commit(types.ADD_EVENT_ORDER, payload)
    },

    saveOrder({ commit }, payload) {
        commit(types.SAVE_ORDER, payload)
    },

    saveOrderLocation({ commit }, payload) {
        commit(types.SAVE_ORDER_LOCATION, payload)
    },

    saveCourierActive({ commit }, payload) {
        commit(types.SAVE_COURIER_ACTIVE, payload)
    }
}
