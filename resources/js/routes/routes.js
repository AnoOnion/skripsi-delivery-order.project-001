function page (path) {
    return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
    /* Authenticate Pages */
    {
        path: '/login', /* Done */
        name: 'auth.login',
        meta: { title: 'Login Management' },
        component: page('user/auth/Login.vue')
    },
    {
        path: '/register', /* Done */
        name: 'auth.register',
        meta: { title: 'Register Management' },
        component: page('user/auth/Register.vue')
    },

    /* Verification Pages */
    {
        path: '/email/check',
        name: 'verify.check',
        meta: { title: '' },
        component: page('user/auth/verification/CheckEmail.vue')
    },
    {
        path: '/email/expired',
        name: 'verify.expired',
        meta: { title: '' },
        component: page('user/auth/verification/ExpiredEmailVerify.vue')
    },
    {
        path: '/email/resend/:email?',
        name: 'verify.resend',
        meta: { title: '' },
        component: page('user/auth/verification/ResendVerification.vue')
    },
    {
        path: '/email/verify/:id',
        name: 'verify.email',
        meta: { title: '' },
        component: page('user/auth/verification/VerifyAccount.vue')
    },

    /* Forget Password Pages */
    {
        path: '/password/reset', /* Done */
        name: 'password.reset',
        meta: { title: 'Reset Password Management' },
        component: page('user/auth/password/ForgetPassword.vue')
    },
    {
        path: '/password/reset/:token', /* Done */
        name: 'password.verify',
        meta: { title: '' },
        component: page('user/auth/password/PasswordReset.vue')
    },

    /* Dashboard */
    {
        path: '/',
        component: page('user/App.vue'),
        children: [
            {
                path: '',
                name: 'dashboard.index',
                meta: { title: 'Dashboard - Home', map: false, wide: false },
                component: page('user/pages/Home.vue'),
            },
            {
                path: 'order',
                name: 'dashboard.order',
                meta: { title: 'Dashboard - Order', map: true, wide: false },
                component: page('user/pages/Order.vue'),
            },
            {
                path: 'history',
                name: 'dashboard.history',
                meta: { title: 'Dashboard - History', map: false, wide: false },
                component: page('user/pages/History.vue'),
            },

            {
                path: 'setting',
                name: 'dashboard.setting',
                meta: { title: 'Dashboard - Setting', map: false, wide: true },
                component: page('user/pages/Setting.vue'),
            },
            {
                path: 'about',
                name: 'dashboard.about',
                meta: { title: 'Dashboard - About', map: false, wide: false },
                component: page('user/pages/About.vue'),
            },

            {
                path: 'article/:slug?',
                name: 'dashboard.article',
                meta: { title: 'Dashboard - Article', map: false, wide: false },
                component: page('user/pages/Article.vue'),
            },
        ]
    },

    /* Policy Pages */
    {
        path: '/terms',
        name: 'policy.terms',
        meta: { title: '' },
        component: page('user/auth/Register.vue')
    },
    {
        path: '/privacy-policy',
        name: 'policy.privacy',
        meta: { title: '' },
        component: page('user/auth/Register.vue')
    },

    /* Page not found */
    {
        path: '/:catchAll(.*)',
        component: page('errors/404.vue')
    }
]
