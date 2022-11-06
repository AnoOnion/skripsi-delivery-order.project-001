import store from '~/store'

export default async (to, from, args, next) => {
    const paramRoute = { name: args == 'user' ? 'auth.login' : 'admin.auth.login' }

    if (! store.getters['auth/check']) {
        next(paramRoute)
    } else {
        store.getters['auth/role'] != args ? next(paramRoute) : next()
    }
}
