import axios from 'axios'
import cookie from 'js-cookie'
import jwt_decode from 'jwt-decode'

import * as types from '../mutation-types'

const token   = cookie.get('token')
const deToken = token ? jwt_decode(token) : null

// state
export const state = {
    user: null,
    role: token ? deToken.role : null,
    level: token ? deToken.level : null,
    token
}

// getters
export const getters = {
    user: state => state.user,
    role: state => state.role,
    level: state => state.level,
    token: state => state.token,
    check: state => state.user !== null
}

// mutations
export const mutations = {
    [types.SAVE_TOKEN](state, { token, remember }) {
        state.token = token

        state.role  = jwt_decode(token).role
        state.level = jwt_decode(token).level

        cookie.set('token', token, {
            expires: remember ? 365 : 1
        })
    },

    [types.FETCH_USER_SUCCESS] (state, { user }) {
        state.user  = user
    },

    [types.FETCH_USER_FAILURE](state) {
        state.token = null

        state.role  = null
        state.level = null

        cookie.remove('token')
    },

    [types.LOGOUT] (state) {
        state.user  = null
        state.token = null

        state.role  = null
        state.level = null

        cookie.remove('token')
    }
}

// actions
export const actions = {
    saveToken({ commit }, payload) {
        commit(types.SAVE_TOKEN, payload)
    },

    saveDataUser({ commit }, payload) {
        commit(types.FETCH_USER_SUCCESS, payload)
    },

    async fetchUser({ commit, state }) {
        try {
            const { data } = await axios.get('/api/' + state.role)

            commit(types.FETCH_USER_SUCCESS, {
                user: data.user
            })
        } catch (e) {
            commit(types.FETCH_USER_FAILURE)
        }
    },

    async logout ({ commit, state }) {
        try {
            await axios.post('/api/' + state.role + '/logout')
        } catch (e) { }
    
        commit(types.LOGOUT)
    }
}
