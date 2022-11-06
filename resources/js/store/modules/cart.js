import cookie from 'js-cookie'
import * as types from '../mutation-types'

const getCartByCookie = cookie.get('cart-data')

const calcTotalPrice  = (state) => {
    state.totalPrice  = 0

    state.items.map(value => value.total).forEach(value => {
        state.totalPrice += parseInt(value)
    })
}

// state
export const state = {
    items: getCartByCookie ? JSON.parse(getCartByCookie).items : [],
    totalPrice: getCartByCookie ? JSON.parse(getCartByCookie).totalPrice : 0
}

// getters
export const getters = {
    items: state => state.items,
    totalPrice: state => state.totalPrice
}

// mutations
export const mutations = {
    [types.SAVE_CART](state, { stock, item }) {
        let index = state.items.findIndex(value => value.id == item.id)

        if (index >= 0) {
            let items = state.items[index]

            if (items.qty < stock) {
                state.items[index] = {
                    ...items, qty: (items.qty + 1), total: ((items.qty + 1) * items.price)
                }
            }
        } else {
            state.items.push(item)
        }

        calcTotalPrice(state)

        cookie.set('cart-data', JSON.stringify(state), {
            expires: 30
        })
    },

    [types.UPDATE_CART](state, item) {
        let items = state.items[item.index]

        state.items[item.index] = {
            ...items, qty: item.qty, total: (item.qty * items.price)
        }

        calcTotalPrice(state)

        cookie.set('cart-data', JSON.stringify(state), {
            expires: 30
        })
    },

    [types.REMOVE_CART](state, item) {
        state.items.splice(item.index, 1)

        calcTotalPrice(state)

        cookie.set('cart-data', JSON.stringify(state), {
            expires: 30
        })
    },

    [types.RESET_CART](state) {
        state.items      = []
        state.totalPrice = 0

        cookie.set('cart-data', JSON.stringify(state), {
            expires: 30
        })
    }
}

// actions
export const actions = {
    saveCart({ commit }, payload) {
        commit(types.SAVE_CART, payload)
    },

    updateCart({ commit }, payload) {
        commit(types.UPDATE_CART, payload)
    },

    removeCart({ commit }, payload) {
        commit(types.REMOVE_CART, payload)
    },

    resetCart({ commit }) {
        commit(types.RESET_CART)
    }
}
