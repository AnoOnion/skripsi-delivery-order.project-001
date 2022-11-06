import store from '~/store'

export default async (to, from, args, next) => {
    const paramRoute = { name: 'admin.auth.login' }

    if (! store.getters['auth/check']) {
        next(paramRoute)
    } else {
        store.getters['auth/level'] != args ? next(paramRoute) : next()
    }
}
