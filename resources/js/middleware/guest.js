import store from '~/store'

export default async (to, from, args, next) => {
    if (store.getters['auth/check'] && store.getters['auth/role'] == args) {
        next({ name: args == 'user' ? 'dashboard.index' : 'admin.dashboard.index' })
    } else {
        next()
    }
}
