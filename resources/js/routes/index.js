import { createWebHistory, createRouter } from 'vue-router'

import routes from './routes-admin'

const defaulTitle = 'San-Qua Karanganyar';
const descriptionTitle = 'Aplikasi Pesan Antar Isi Ulang Air Mineral'

const globalMiddleware = ['check-auth']

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.matched.some(m => m.meta.disableScroll)) return;

        const position = {
            left: savedPosition ? savedPosition.left : 0,
            top: savedPosition ? savedPosition.top : 0,
            behavior: 'smooth'
        }

        return new Promise((resolve) => {
            setTimeout(() => resolve(position), 200)
        })
    }
})

const requireContext = require.context('~/middleware', false, /.*\.js$/)

const routeMiddleware = requireContext.keys().map(file => [
                            file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)
                        ]).reduce((guards, [name, guard]) => ({
                            ...guards, [name]: guard.default
                        }), {})

const callMiddleware = async (middleware, to, from, next) => {
    const stack = middleware.reverse()

    const _next = async (...args) => {
        let paramMiddleware = null

        if (args.length > 0 || stack.length === 0) {
            return next(...args)
        }

        const middleware = stack.pop()

        if (typeof middleware !== 'function') {
            paramMiddleware = middleware.split(':')
        }

        if (typeof middleware === 'function') {
            await middleware(to, from, _next)
        } else if (routeMiddleware[paramMiddleware[0]]) {
            await routeMiddleware[paramMiddleware[0]](to, from, paramMiddleware[1], _next)
        } else {
            throw Error(`Undefined middleware [${middleware}]`)
        }
    }

    await _next()
}

router.beforeEach(async (to, from, next) => {
    let components = []

    try {
        components = await Promise.all(to.matched.map(({ components }) => {
            let component = components.default
            return typeof component === 'function' ? component() : component
        }))
    } catch (error) {
        if (/^Loading( CSS)? chunk (\d)+ failed\./.test(error.message)) {
            window.location.reload(true)
            return
        }
    }

    if (components.length === 0) {
        return next()
    }

    const middlewareList = [...globalMiddleware]

    components.filter(c => c.middleware).forEach(({ middleware }) => {
        Array.isArray(middleware) ? middlewareList.push(...middleware) : middlewareList.push(middleware)
    })

    await callMiddleware(middlewareList, to, from, (...args) => {
        next(...args)
    })
})

router.afterEach(async (to, from, next) => {
    document.title = (to.meta.title || defaulTitle) + ' | ' + descriptionTitle
})

export default router;
